<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferStockHistoryModel extends Model
{
    protected $table = 'transfer_stock_history';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'department',
        'pic',
        'tanggal',
        'part_number_from',
        'part_number_to',
        'qty',
        'lot_number_from',
        'lot_number_to',
        'rn_from',
        'rn_to',
        'warehouse_from',
        'warehouse_to',
        'status',
        'remark',
        'pic_action_date',
        'adjust_pic',
        'created_at'
    ];

    protected $returnType = 'array';

}
