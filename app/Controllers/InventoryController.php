<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use CodeIgniter\Controller;
use App\Models\TransferStockModel;
use App\Models\CancelLotModel;

class InventoryController extends Controller
{
    public function index()
    {
        $model = new InventoryModel();
        $data['inventory'] = $model->getAllData();

        return view('inventory_view', $data);
    }

    public function getPartNumbers()
    {
        $searchTerm = $this->request->getGet('term');

        // Menghubungkan ke database SQL Server
        $db = \Config\Database::connect('sqlsrv');

        // Menyiapkan query SQL
        $query = $db->query("
            SELECT T0.[ItemCode], T0.[WhsCode], T1.[U_MIS_NextProses] AS 'Storage Location',
                   T0.[OnHand], T1.[ItmsGrpCod], T1.[ValidFor] AS 'Active or Not'
            FROM OITW T0
            INNER JOIN OITM T1 ON T0.[ItemCode] = T1.[ItemCode]
            WHERE
                T0.[WhsCode] NOT IN ('WHSCRAP','WHWIPPEN','WHBESC','WHSC04','WHSC05','WHSC06','WHSC08')
                AND (T1.[ItmsGrpCod] IN (110, 111, 112, 113, 114))
                AND T0.[ItemCode] LIKE ?
        ", ["%$searchTerm%"]);

        // Mendapatkan hasil query
        $results = $query->getResultArray();

        // Menghapus duplikasi
        $uniquePartNumbers = [];
        foreach ($results as $item) {
            $uniquePartNumbers[$item['ItemCode']] = $item['ItemCode'];
        }

        // Format data untuk autocomplete
        $formattedData = [];
        foreach ($uniquePartNumbers as $partNumber) {
            $formattedData[] = [
                'label' => $partNumber, // Sesuaikan dengan kolom yang menjadi label
                'value' => $partNumber  // Sesuaikan dengan kolom yang menjadi value
            ];
        }

        // Mengembalikan data dalam format JSON
        return $this->response->setJSON($formattedData);
    }


    public function getLocations()
    {
        $searchTerm = $this->request->getGet('term');
        $db = \Config\Database::connect('sqlsrv'); // Koneksi ke SQL Server

        $builder = $db->table('OWHS'); // Misal nama tabelnya OWHS
        $builder->select('WhsCode as value, WhsCode as label'); // Sesuaikan dengan kolom yang Anda butuhkan
        $builder->like('WhsCode', $searchTerm, 'both');

        $query = $builder->get();
        $data = $query->getResultArray();

        return $this->response->setJSON($data);
    }

    public function save()
    {
        $modelMySQL = new InventoryModel();

        $department = $this->request->getPost('department');
        $pic = $this->request->getPost('pic');
        $partNumber = $this->request->getPost('part_number');
        $qty = $this->request->getPost('qty');
        $lotNumber = $this->request->getPost('lot_number');
        $rn = $this->request->getPost('rn');
        $location = $this->request->getPost('location');
        $status = $this->request->getPost('status');
        $remark = $this->request->getPost('remark');

        $data = [
            'department' => $department,
            'pic' => $pic,
            'part_number' => $partNumber,
            'tanggal' => date('Y-m-d'),
            'qty' => $qty,
            'lot_number' => $lotNumber,
            'rn' => $rn,
            'location' => $location,
            'status' => $status,
            'remark' => $remark,
        ];

        $modelMySQL->saveToMySQL($data);

        return redirect()->to('/inventory')->with('message', 'Data berhasil disimpan.');
    }

    // baruuu
    public function update()
    {
        $model = new InventoryModel();

        // Validasi input
        $validation = \Config\Services::validation();
        $rules = [
            'department' => 'required',
            'pic' => 'required',
            'part_number' => 'required',
            'qty' => 'required|numeric',
            'lot_number' => 'required',
            'rn' => 'required',
            'location' => 'required',
            'status' => 'required',
            'remark' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data dari form
        $id = $this->request->getPost('id');
        $data = [
            'department' => $this->request->getPost('department'),
            'pic' => $this->request->getPost('pic'),
            'part_number' => $this->request->getPost('part_number'),
            'qty' => $this->request->getPost('qty'),
            'lot_number' => $this->request->getPost('lot_number'),
            'rn' => $this->request->getPost('rn'),
            'location' => $this->request->getPost('location'),
            'status' => $this->request->getPost('status'),
            'remark' => $this->request->getPost('remark'),
        ];

        // Update data di database
        $model->update($id, $data);

        // Redirect kembali ke halaman sebelumnya
        return redirect()->to(previous_url())->with('success', 'Data updated successfully.');
    }

    public function delete($id)
    {
        $model = new InventoryModel();
        $model->deleteData($id);

        return $this->response->setJSON(['message' => 'Data berhasil dihapus.']);
    }


    public function transferStock()
    {
        $model = new TransferStockModel();
        $data['transferStock'] = $model->findAll();
        return view('transfer_stock_view', $data);
    }

    public function saveTransferStock()
    {
        $model = new TransferStockModel();

        $department = $this->request->getPost('department');
        $pic = $this->request->getPost('pic');
        $partNumberFrom = $this->request->getPost('part_number_from');
        $partNumberTo = $this->request->getPost('part_number_to');
        $qty = $this->request->getPost('qty');
        $lotNumberFrom = $this->request->getPost('lot_number_from');
        $lotNumberTo = $this->request->getPost('lot_number_to');
        $rnFrom = $this->request->getPost('rn_from');
        $rnTo = $this->request->getPost('rn_to');
        $warehouseFrom = $this->request->getPost('warehouse_from');
        $warehouseTo = $this->request->getPost('warehouse_to');
        $status = $this->request->getPost('status');
        $remark = $this->request->getPost('remark');

        $data = [
            'department' => $department,
            'pic' => $pic,
            'tanggal' => date('Y-m-d'),
            'part_number_from' => $partNumberFrom,
            'part_number_to' => $partNumberTo,
            'qty' => $qty,
            'lot_number_from' => $lotNumberFrom,
            'lot_number_to' => $lotNumberTo,
            'rn_from' => $rnFrom,
            'rn_to' => $rnTo,
            'warehouse_from' => $warehouseFrom,
            'warehouse_to' => $warehouseTo,
            'status' => $status,
            'remark' => $remark,
            'adjust_pic' => null, // Misalnya awalnya statusnya null
            'created_at' => date('Y-m-d H:i:s')
        ];

        $model->insert($data);

        return redirect()->to('/inventory/transfer')->with('message', 'Data Transfer Stock berhasil disimpan.');
    }


    public function updateTransferStock()
    {
        $model = new TransferStockModel();

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'department' => 'required',
            'pic' => 'required',
            'part_number_from' => 'required',
            'part_number_to' => 'required',
            'qty' => 'required|numeric',
            'lot_number_from' => 'required',
            'lot_number_to' => 'required',
            'rn_from' => 'required',
            'rn_to' => 'required',
            'warehouse_from' => 'required',
            'warehouse_to' => 'required',
            'status' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data dari request
        $id = $this->request->getPost('id');
        $data = [
            'department' => $this->request->getPost('department'),
            'pic' => $this->request->getPost('pic'),
            'part_number_from' => $this->request->getPost('part_number_from'),
            'part_number_to' => $this->request->getPost('part_number_to'),
            'qty' => $this->request->getPost('qty'),
            'lot_number_from' => $this->request->getPost('lot_number_from'),
            'lot_number_to' => $this->request->getPost('lot_number_to'),
            'rn_from' => $this->request->getPost('rn_from'),
            'rn_to' => $this->request->getPost('rn_to'),
            'warehouse_from' => $this->request->getPost('warehouse_from'),
            'warehouse_to' => $this->request->getPost('warehouse_to'),
            'status' => $this->request->getPost('status'),
            'remark' => $this->request->getPost('remark'),
        ];

        // Update data di database
        if ($model->update($id, $data)) {
            return redirect()->back()->with('successTransfer', 'Transfer stock updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update transfer stock.');
        }
    }


    public function deleteTransferStock($id)
    {
        $model = new TransferStockModel();

        // Cek apakah ID yang diberikan ada
        if ($model->find($id)) {
            // Lakukan penghapusan berdasarkan ID
            $model->delete($id);

            // Mengembalikan respons JSON
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Transfer Stock berhasil dihapus.'
            ]);
        } else {
            // Mengembalikan respons JSON jika ID tidak ditemukan
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }


    public function cancelLot()
    {
        $model = new CancelLotModel();
        $data['cancelLot'] = $model->findAll();
        return view('cancel_lot_view', $data);
    }

    public function saveCancelLot()
    {
        $model = new CancelLotModel();

        $department = $this->request->getPost('department');
        $pic = $this->request->getPost('pic');
        $partNumberFrom = $this->request->getPost('part_number_from');
        $partNumberTo = $this->request->getPost('part_number_to');
        $qty = $this->request->getPost('qty');
        $lotNumber = $this->request->getPost('lot_number');
        $warehouseFrom = $this->request->getPost('warehouse_from');
        $warehouseTo = $this->request->getPost('warehouse_to');
        $remark = $this->request->getPost('remark');

        $data = [
            'department' => $department,
            'pic' => $pic,
            'tanggal' => date('Y-m-d'),
            'part_number_from' => $partNumberFrom,
            'part_number_to' => $partNumberTo,
            'qty' => $qty,
            'lot_number' => $lotNumber,
            'warehouse_from' => $warehouseFrom,
            'warehouse_to' => $warehouseTo,
            'remark' => $remark,
            'adjust_pic' => null, // Misalnya awalnya statusnya null
            'created_at' => date('Y-m-d H:i:s')
        ];

        $model->insert($data);

        return redirect()->to('/inventory/cancel')->with('message', 'Data Cancel Lot berhasil disimpan.');
    }

    public function updateCancelLot()
    {
        $id = $this->request->getPost('id'); // Ambil id dari POST data
        $model = new CancelLotModel();

        // Ambil data dari request
        $department = $this->request->getPost('department');
        $pic = $this->request->getPost('pic');
        $partNumberFrom = $this->request->getPost('part_number_from');
        $partNumberTo = $this->request->getPost('part_number_to');
        $qty = $this->request->getPost('qty');
        $lotNumber = $this->request->getPost('lot_number');
        $warehouseFrom = $this->request->getPost('warehouse_from');
        $warehouseTo = $this->request->getPost('warehouse_to');
        $remark = $this->request->getPost('remark');

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'department' => 'required',
            'pic' => 'required',
            'part_number_from' => 'required',
            'part_number_to' => 'required',
            'qty' => 'required|integer',
            'lot_number' => 'required|integer',
            'warehouse_from' => 'required',
            'warehouse_to' => 'required',
            'remark' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Data untuk update
        $data = [
            'department' => $department,
            'pic' => $pic,
            'part_number_from' => $partNumberFrom,
            'part_number_to' => $partNumberTo,
            'qty' => $qty,
            'lot_number' => $lotNumber,
            'warehouse_from' => $warehouseFrom,
            'warehouse_to' => $warehouseTo,
            'remark' => $remark,
        ];

        // Update data
        if ($model->update($id, $data)) {
            return redirect()->back()->with('successCancel', 'Transfer stock updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update transfer stock.');
        }
    }


    public function deleteCancelLot($id)
    {
        $model = new CancelLotModel();

        // Hapus data
        if ($model->delete($id)) {
            // Jika berhasil dihapus, kembalikan respons JSON sukses
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Cancel Lot berhasil dihapus.'
            ]);
        } else {
            // Jika gagal dihapus, kembalikan respons JSON error
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus data Cancel Lot.'
            ]);
        }
    }


    // Warehouse automatic by adjusment
    public function getWarehouseByItemCode()
    {
        $itemCode = $this->request->getPost('itemCode');

        $db = \Config\Database::connect('sqlsrv'); // koneksi database ke sql server

        $query = $db->query("
        SELECT T0.[WhsCode]
        FROM OITW T0 INNER JOIN OITM T1 ON T0.[ItemCode] = T1.[ItemCode]
        WHERE
        T0.[WhsCode] NOT IN ('WHSCRAP','WHWIPPEN','WHBESC','WHSC04','WHSC05','WHSC06','WHSC08')
        AND (T1.[ItmsGrpCod] = 110 OR
             T1.[ItmsGrpCod] = 111 OR
             T1.[ItmsGrpCod] = 112 OR
             T1.[ItmsGrpCod] = 113 OR
             T1.[ItmsGrpCod] = 114)
        AND T1.Validfor = 'Y'
        AND T0.[ItemCode] = ?
    ", [$itemCode]);

        $results = $query->getResultArray();

        return $this->response->setJSON($results);
    }

    // automtic PN and WH by Cancel Lot
    public function getPartNumberSuggestions()
    {
        if ($this->request->isAJAX()) {
            $term = $this->request->getPost('term');

            $db = \Config\Database::connect('sqlsrv');
            $sql = "
                SELECT DISTINCT T0.[Code] as 'label'
                FROM OITT T0
                INNER JOIN OITM T2 ON T0.[Code] = T2.[ItemCode]
                WHERE T2.[ValidFor] = 'Y'
                AND T0.[ToWH] != '01'
                AND T0.[Code] LIKE ?
            ";

            $query = $db->query($sql, ['%' . $term . '%']);
            $results = $query->getResultArray();

            $suggestions = [];
            foreach ($results as $row) {
                $suggestions[] = ['label' => $row['label'], 'value' => $row['label']];
            }

            return $this->response->setJSON($suggestions);
        }
    }

    public function getPartNumberDetails()
    {
        if ($this->request->isAJAX()) {
            $partNumberFrom = $this->request->getPost('part_number_from');

            $db = \Config\Database::connect('sqlsrv');
            $sql = "
                SELECT T0.[Code] as 'PN Cancelan', T0.[ToWH] as 'WH Cancelan',
                       T1.[Code] as 'PN Kembali', T1.[Warehouse] as 'WH Kembali'
                FROM OITT T0
                INNER JOIN ITT1 T1 ON T0.[Code] = T1.[Father]
                INNER JOIN OITM T2 ON T0.[Code] = T2.[ItemCode]
                WHERE T2.[ValidFor] = 'Y'
                AND T0.[ToWH] != '01'
                AND T0.[Code] = ?
            ";

            $query = $db->query($sql, [$partNumberFrom]);
            $result = $query->getRowArray();

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'part_number_to' => $result['PN Kembali'],
                    'warehouse_from' => $result['WH Cancelan'],
                    'warehouse_to' => $result['WH Kembali']
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Part number details not found.'
                ]);
            }
        }
    }

    // baru ni, untuk automatic warehouse to ketika part number to diganti.
    public function getWarehouseToByPartNumberTo()
    {
        $partNumberTo = $this->request->getPost('part_number_to');

        $db = \Config\Database::connect('sqlsrv'); // koneksi database ke sql server

        $query = $db->query("
            SELECT T0.[WhsCode] as warehouse_to
            FROM OITW T0 INNER JOIN OITM T1 ON T0.[ItemCode] = T1.[ItemCode]
            WHERE
            T0.[WhsCode] NOT IN ('WHSCRAP','WHWIPPEN','WHBESC','WHSC04','WHSC05','WHSC06','WHSC08')
            AND (T1.[ItmsGrpCod] = 110 OR
                 T1.[ItmsGrpCod] = 111 OR
                 T1.[ItmsGrpCod] = 112 OR
                 T1.[ItmsGrpCod] = 113 OR
                 T1.[ItmsGrpCod] = 114)
            AND T1.Validfor = 'Y'
            AND T0.[ItemCode] = ?
        ", [$partNumberTo]);

        $result = $query->getRowArray();

        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'warehouse_to' => $result['warehouse_to']
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Warehouse not found for the given part number.'
            ]);
        }
    }
}


