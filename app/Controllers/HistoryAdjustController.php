<?php

namespace App\Controllers;

use App\Models\HistoryModel;

class HistoryAdjustController extends BaseController
{
    protected $historyModel;

    public function __construct()
    {
        // Inisialisasi model di konstruktor
        $this->historyModel = new HistoryModel();
    }

    public function index()
    {
        $model = new HistoryModel();
        $data['history'] = $model->findAll(); // Ambil semua data dari database

        // Kirim data ke view
        return view('history/history_adjust', $data);
    }

    public function getHistoryData()
    {
        // Ambil data dari model
        $data = $this->historyModel->findAll();

        // Kirim data dalam format JSON
        return $this->response->setJSON($data);
    }
}
