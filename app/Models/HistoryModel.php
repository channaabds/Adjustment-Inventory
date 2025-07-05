<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryModel extends Model
{
    protected $table = 'tb_historyadjust'; // Nama tabel history
    protected $primaryKey = 'id'; // Primary key tabel

    protected $allowedFields = [
        'pic',
        'department',
        'part_number',
        'tanggal',
        'qty',
        'lot_number',
        'rn',
        'location',
        'status',
        'remark',
        'adjust_pic',
        'created_at',
        'pic_action_date',
        'review_at'
    ];

    // Jika ada waktu atau field lain di tabel history, tambahkan disini
}

