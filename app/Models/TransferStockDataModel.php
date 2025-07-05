<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferStockDataModel extends Model
{
    protected $table = 'transfer_stock';
    protected $primaryKey = 'id';
    protected $allowedFields = ['department', 'part_number_from', 'part_number_to', 'qty', 'lot_number', 'warehouse_from', 'warehouse_to', 'status', 'adjust_pic', 'created_at'];
}
