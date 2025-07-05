<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferStockModel extends Model
{
    protected $table = 'transfer_stock';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'department',
        'pic',
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
        'adjust_pic'
    ];


}
