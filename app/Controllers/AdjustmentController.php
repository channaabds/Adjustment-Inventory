<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\HistoryModel;
use CodeIgniter\Controller;

class AdjustmentController extends Controller
{
    protected $adjustmentModel;
    protected $historyModel;

    public function __construct()
    {
        $this->adjustmentModel = new InventoryModel();
        $this->historyModel = new HistoryModel();
    }

    public function approve($id) {
        // Ambil data dari tabel utama
        $item = $this->db->table('user_inputs')->where('id', $id)->get()->getRowArray();
        if ($item) {
            // Hapus data dari tabel utama
            $this->db->table('user_inputs')->where('id', $id)->delete();
    
            // Tambahkan data ke tabel sejarah
            $this->db->table('tb_historyadjust')->insert($item);
    
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-approve dan dipindahkan']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
    }

    public function disapprove($id)
    {
        $response = ['success' => false, 'message' => ''];

        try {
            $reason = $this->request->getPost('reason');

            if (!$id || !is_numeric($id)) {
                throw new \Exception('ID tidak valid');
            }

            $adjustment = $this->adjustmentModel->getData($id);
            if (!$adjustment) {
                throw new \Exception('Data tidak ditemukan');
            }

            $this->adjustmentModel->update($id, ['adjust_pic' => 'disapproved']);

            $historyData = [
                'pic' => $adjustment['pic'],
                'department' => $adjustment['department'],
                'part_number' => $adjustment['part_number'],
                'tanggal' => $adjustment['tanggal'],
                'qty' => $adjustment['qty'],
                'lot_number' => $adjustment['lot_number'],
                'location' => $adjustment['location'],
                'status' => 'disapproved',
                'remark' => $adjustment['remark'],
                'adjust_pic' => 'disapproved',
                'review_at' => date('Y-m-d H:i:s'),
            ];

            $this->historyModel->insert($historyData);

            $response = ['success' => true, 'message' => 'Data berhasil ditolak'];
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return $this->response->setJSON($response);
    }
}
