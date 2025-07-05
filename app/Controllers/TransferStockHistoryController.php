<?php

namespace App\Controllers;

use App\Models\TransferStockHistoryModel;

class TransferStockHistoryController extends BaseController
{
    public function index()
    {
        $model = new TransferStockHistoryModel();
        $data['transferStockHistory'] = $model->findAll(); // Mengambil semua data dari model

        return view('History/transfer_stock_history_view', $data);
    }
}
