<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'user_inputs'; // Nama tabel Anda di MySQL

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
        'pic_action_date',
        'created_at'

    ];

    public function getAllData()
    {
        return $this->findAll();
    }

    public function saveToMySQL($data)
    {
        return $this->insert($data); // Menggunakan insert dari CodeIgniter Model
    }

    public function getDataById($id)
    {
        return $this->find($id);
    }

    public function updateData($id, $data)
    {
        return $this->update($id, $data); // Menggunakan update dari CodeIgniter Model
    }

    public function deleteData($id)
    {
        return $this->delete($id); // Menggunakan delete dari CodeIgniter Model
    }
}
