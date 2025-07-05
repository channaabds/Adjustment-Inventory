<?php

namespace App\Models;

use CodeIgniter\Model;

class AllCancelModel extends Model
{
    protected $table = 'tb_allcancel';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'department',
        'pic',
        'tanggal',
        'part_number_from',
        'part_number_to',
        'qty',
        'lot_number',
        'warehouse_from',
        'warehouse_to',
        'remark',
        'adjust_pic',
        'created_at',
        'pic_action_date'
    ];
}
