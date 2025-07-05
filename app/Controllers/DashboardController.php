<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CancelLotModel;
use App\Models\TransferStockModel;
use App\Models\InventoryModel;
use App\Models\HistoryModel;
use App\Models\TransferStockHistoryModel;
use App\Models\AllCancelModel;

class DashboardController extends Controller
{
    public function index()
    {
        // Inisialisasi model
        $modelCancelLot = new CancelLotModel();
        $modelTransferStock = new TransferStockModel();
        $modelInventory = new InventoryModel();

        // Mendapatkan peran pengguna dari sesi
        $session = session();
        $userRole = $session->get('role'); // Sesuaikan dengan cara Anda mendapatkan peran pengguna

        // Jika peran pengguna termasuk dalam peran yang memerlukan akses ke dashboard PIC, arahkan ke dashboard PIC
        if (in_array($userRole, ['LEADERMFG1', 'LEADERMFG2', 'LEADERQC', 'PIC', 'PIC2'])) {
            return redirect()->to('/PIC/pic_dashboard'); // Pastikan rute ini benar
        }

        // Hitung jumlah data untuk setiap card
        $adjustmentInventoryCount = $modelInventory->countAll();
        $cancelLotCount = $modelCancelLot->countAll();

        // Variabel untuk Transfer Stock
        $transferStockCount = 0;
        if (!in_array($userRole, ['MFG1', 'MFG2'])) {
            $transferStockCount = $modelTransferStock->countAll();
        }

        // Hitung jumlah berdasarkan kondisi adjust_pic IS NULL
        $waitingApprovedCountInventory = $modelInventory->where('adjust_pic', null)->countAllResults();
        $waitingApprovedCountTransferStock = (!in_array($userRole, ['MFG1', 'MFG2'])) ?
            $modelTransferStock->where('adjust_pic', null)->countAllResults() : 0;
        $waitingApprovedCountCancelLot = $modelCancelLot->where('adjust_pic', null)->countAllResults();

        // Hitung jumlah berdasarkan kondisi adjust_pic = 'approved'
        $approvedCountInventory = $modelInventory->like('adjust_pic', 'approved')->countAllResults();
        $approvedCountTransferStock = (!in_array($userRole, ['MFG1', 'MFG2'])) ?
            $modelTransferStock->like('adjust_pic', 'approved')->countAllResults() : 0;
        $approvedCountCancelLot = $modelCancelLot->like('adjust_pic', 'approved')->countAllResults();

        // Hitung jumlah berdasarkan kondisi adjust_pic LIKE '%Disapproved%'
        $disapprovedCountInventory = $modelInventory->like('adjust_pic', 'disapproved')->countAllResults();
        $disapprovedCountTransferStock = (!in_array($userRole, ['MFG1', 'MFG2'])) ?
            $modelTransferStock->like('adjust_pic', 'disapproved')->countAllResults() : 0;
        $disapprovedCountCancelLot = $modelCancelLot->like('adjust_pic', 'disapproved')->countAllResults();

        // Gabungkan hasil dari beberapa model untuk waiting approved dan disapproved
        $waitingApprovedCount = $waitingApprovedCountInventory + $waitingApprovedCountTransferStock + $waitingApprovedCountCancelLot;
        $approvedCount = $approvedCountInventory + $approvedCountTransferStock + $approvedCountCancelLot;
        $disapprovedCount = $disapprovedCountInventory + $disapprovedCountTransferStock + $disapprovedCountCancelLot;

        // Data yang akan dikirim ke tampilan
        $data = [
            'userRole' => $userRole, // Kirimkan userRole ke tampilan
            'adjustmentInventoryCount' => $adjustmentInventoryCount,
            'transferStockCount' => $transferStockCount,
            'cancelLotCount' => $cancelLotCount,
            'waitingApprovedCount' => $waitingApprovedCount,
            'approvedCount' => $approvedCount,
            'disapprovedCount' => $disapprovedCount,
        ];

        return view('dashboard', $data);
    }




    public function waitingApproved()
    {
        $session = session();
        $userRole = $session->get('role');

        $inventoryModel = new InventoryModel();
        $waitingApprovedItems = $inventoryModel->where('adjust_pic IS NULL', null, false)->findAll();

        $modelTransferStock = new TransferStockModel();
        $waitingApprovedItemsTransfer = ($userRole !== 'MFG1' && $userRole !== 'MFG2') ?
            $modelTransferStock->where('adjust_pic IS NULL', null, false)->findAll() : [];

        $cancelLotModel = new CancelLotModel();
        $waitingApprovedItemsCancelLot = $cancelLotModel->where('adjust_pic IS NULL', null, false)->findAll();

        return view('waiting_approved', [
            'waitingApprovedItems' => $waitingApprovedItems,
            'waitingApprovedItemsTransfer' => $waitingApprovedItemsTransfer,
            'waitingApprovedItemsCancelLot' => $waitingApprovedItemsCancelLot,
            'userRole' => $userRole // Pastikan ini ada
        ]);
    }


    public function approved()
    {
        // Inisialisasi session
        $session = session();

        // Dapatkan tanggal hari ini
        $today = date('Y-m-d');

        // Model untuk Inventory
        $inventoryModel = new InventoryModel();
        $approvedItemsInventory = $inventoryModel
            ->whereIn('adjust_pic', ['Approved PIC', 'Approved Leader']) // Filter berdasarkan PIC dan Leader
            ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
            ->findAll();

        // Model untuk Transfer Stock
        $modelTransferStock = new TransferStockModel();
        $approvedItemsTransfer = ($session->get('role') !== 'MFG1' && $session->get('role') !== 'MFG2') ?
            $modelTransferStock
                ->whereIn('adjust_pic', ['Approved PIC', 'Approved Leader']) // Filter berdasarkan PIC dan Leader
                ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
                ->findAll() : [];

        // Model untuk Cancel Lot
        $cancelLotModel = new CancelLotModel();
        $approvedItemsCancelLot = $cancelLotModel
            ->whereIn('adjust_pic', ['Approved PIC', 'Approved Leader']) // Filter berdasarkan PIC dan Leader
            ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
            ->findAll();

        // Model untuk History Inventory
        $historyModel = new HistoryModel();
        $approvedItemsHistory = $historyModel
            ->whereIn('adjust_pic', ['Approved PIC', 'Approved Leader']) // Filter berdasarkan PIC dan Leader
            ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
            ->findAll();

        // Model untuk History Transfer Stock
        $historyModelTransfer = new TransferStockHistoryModel();
        $approvedItemsHistoryTransfer = $historyModelTransfer
            ->whereIn('adjust_pic', ['Approved PIC', 'Approved Leader']) // Filter berdasarkan PIC dan Leader
            ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
            ->findAll();

        // Model untuk History Cancel Lot
        $historyModelCancel = new AllCancelModel();
        $approvedItemsHistoryCancel = $historyModelCancel
            ->whereIn('adjust_pic', ['Approved PIC', 'Approved Leader']) // Filter berdasarkan PIC dan Leader
            ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
            ->findAll();



        // Menggabungkan data adjusment dari tabel utama dan history
        $combinedApprovedItems = array_merge(
            $approvedItemsInventory,
            $approvedItemsHistory
        );
        // Menggabungkan data Transfer Stock dari tabel utama dan history
        $combinedApprovedItemsTransfer = array_merge(
            $approvedItemsTransfer,
            $approvedItemsHistoryTransfer
        );
        // Menggabungkan data Cancel Lot dari tabel utama dan history
        $combinedApprovedItemsCancel = array_merge(
            $approvedItemsCancelLot,
            $approvedItemsHistoryCancel
        );

        return view('approved', [
            'combinedApprovedItems' => $combinedApprovedItems, // Menyertakan data gabungan
            'combinedApprovedItemsTransfer' => $combinedApprovedItemsTransfer, // Menyertakan data gabungan
            'combinedApprovedItemsCancel' => $combinedApprovedItemsCancel // Menyertakan data gabungan
        ]);
    }


    public function disapproved()
    {
        // Inisialisasi session
        $session = session();

        // Dapatkan tanggal hari ini
        $today = date('Y-m-d');

        // Model untuk Inventory
        $inventoryModel = new InventoryModel();
        $disapprovedItemsInventory = $inventoryModel
            ->like('adjust_pic', 'disapproved') // Filter berdasarkan PIC disapproved
            ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
            ->findAll();

        // Model untuk Transfer Stock
        $modelTransferStock = new TransferStockModel();
        $disapprovedItemsTransfer = ($session->get('role') !== 'MFG1' && $session->get('role') !== 'MFG2') ?
            $modelTransferStock
                ->like('adjust_pic', 'disapproved') // Filter berdasarkan PIC disapproved
                ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
                ->findAll() : [];

        // Model untuk Cancel Lot
        $cancelLotModel = new CancelLotModel();
        $disapprovedItemsCancelLot = $cancelLotModel
            ->like('adjust_pic', 'disapproved') // Filter berdasarkan PIC disapproved
            ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
            ->findAll();

        // Model untuk History Inventory
        $historyModel = new HistoryModel();
        $disapprovedItemsHistory = $historyModel
            ->like('adjust_pic', 'disapproved') // Filter berdasarkan PIC disapproved
            ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
            ->findAll();

        // Model untuk History Transfer Stock
        $historyModelTransfer = new TransferStockHistoryModel();
        $disapprovedItemsHistoryTransfer = $historyModelTransfer
            ->like('adjust_pic', 'disapproved') // Filter berdasarkan PIC disapproved
            ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
            ->findAll();

        // Model untuk History Cancel Lot
        $historyModelCancel = new AllCancelModel();
        $disapprovedItemsHistoryCancel = $historyModelCancel
            ->like('adjust_pic', 'disapproved') // Filter berdasarkan PIC disapproved
            ->where('tanggal', $today) // Filter berdasarkan tanggal hari ini
            ->findAll();

        // Menggabungkan data adjusment dari tabel utama dan history
        $combinedDisapprovedItems = array_merge(
            $disapprovedItemsInventory,
            $disapprovedItemsHistory
        );
        // Menggabungkan data Transfer Stock dari tabel utama dan history
        $combinedDisapprovedItemsTransfer = array_merge(
            $disapprovedItemsTransfer,
            $disapprovedItemsHistoryTransfer
        );
        // Menggabungkan data Cancel Lot dari tabel utama dan history
        $combinedDisapprovedItemsCancel = array_merge(
            $disapprovedItemsCancelLot,
            $disapprovedItemsHistoryCancel
        );

        return view('disapproved', [
            'combinedDisapprovedItems' => $combinedDisapprovedItems, // Menyertakan data gabungan
            'combinedDisapprovedItemsTransfer' => $combinedDisapprovedItemsTransfer, // Menyertakan data gabungan
            'combinedDisapprovedItemsCancel' => $combinedDisapprovedItemsCancel // Menyertakan data gabungan
        ]);
    }



}
