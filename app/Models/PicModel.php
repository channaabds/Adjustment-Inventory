<?php

namespace App\Models;

use CodeIgniter\Model;

class PicModel extends Model
{
    protected $table = 'tb_pic'; // Nama tabel di database
    protected $primaryKey = 'id_pic'; // Primary key tabel

    protected $allowedFields = [
        'nik',
        'pic',
        'jenis_kelamin',
        'dept',
        'position'
    ];

    protected $useTimestamps = true; // Menggunakan created_at dan updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi jika diperlukan
    protected $validationRules = [
        'nik'           => 'required|is_unique[tb_pic.nik]',
        'pic'           => 'required',
        'jenis_kelamin' => 'required|in_list[M,F]',
        'dept'          => 'required',
        'position'      => 'required'
    ];

    protected $validationMessages = [
        'nik' => [
            'required' => 'NIK is required',
            'is_unique' => 'NIK already exists'
        ],
        'jenis_kelamin' => [
            'in_list' => 'Jenis Kelamin must be M or F'
        ]
    ];

    // Jika Anda memerlukan soft delete
    // protected $useSoftDeletes = true;
    // protected $deletedField  = 'deleted_at';
}
