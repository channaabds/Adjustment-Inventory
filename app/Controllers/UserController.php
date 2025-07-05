<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\InventoryModel;
class UserController extends Controller
{
    public function dashboard()
    {
        // Pastikan pengguna yang mengakses halaman ini adalah user biasa
        if (session()->get('role') !== 'user') {
            return redirect()->to('/login');
        }

        // Logic untuk mendapatkan data yang akan ditampilkan di dashboard user
        $db = \Config\Database::connect();
        $query = $db->table('inventory')->get();
        $data['inventory'] = $query->getResult();

        return view('user/dashboard', $data);
    }

    protected $inventoryModel;

    public function __construct()
    {
        $this->inventoryModel = new InventoryModel(); // Inisialisasi model
    }

    public function index()
    {
        return view('dashboard');
    }



    public function indexApproved()
    {
        // Ambil data untuk tampilan utama
        $data = [
            'waitingApprovedCount' => $this->inventoryModel->countByAdjustPicStatus(''),
            'approvedCount' => $this->inventoryModel->countByAdjustPicStatus('Approved'),
            'disapprovedCount' => $this->inventoryModel->countByAdjustPicStatus('Disapproved'),
        ];

        return view('dashboard', $data);
    }

    public function waitingApproved()
    {
        // Ambil data berdasarkan adjust PIC
        $waitingApprovedItems = $this->inventoryModel->where('adjust_pic', '')->findAll();

        $data = [
            'waitingApprovedItems' => $waitingApprovedItems,
        ];

        return view('waiting_approved', $data);
    }

    public function approved()
    {
        // Ambil data berdasarkan adjust PIC
        $approvedItems = $this->inventoryModel->where('adjust_pic', 'Approved')->findAll();

        $data = [
            'approvedItems' => $approvedItems,
        ];

        return view('approved', $data);
    }

    public function disapproved()
    {
        // Ambil data berdasarkan adjust PIC
        $disapprovedItems = $this->inventoryModel->where('adjust_pic', 'Disapproved')->findAll();

        $data = [
            'disapprovedItems' => $disapprovedItems,
        ];

        return view('disapproved', $data);
    }
}
