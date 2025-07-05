<?php

namespace App\Models;

use CodeIgniter\Model;

class CancelLotModel extends Model
{
    protected $table = 'cancel_lot';
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
    public function getFilteredData($startDate, $endDate)
    {
        return $this->db->table('cancel_lot')
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->get()
            ->getResultArray();
    }

    public function getPartNumberTo($partNumberFrom)
    {
        $db = \Config\Database::connect('sqlsrv'); // Ganti dengan koneksi database yang sesuai

        $builder = $db->table('ITT1 T1'); // Sesuaikan dengan nama tabel dan kolom yang sesuai
        $builder->select('T1.Code'); // Sesuaikan dengan kolom yang sesuai
        $builder->where('T1.Father', $partNumberFrom);

        $query = $builder->get();
        $row = $query->getRow();

        if ($row) {
            return $row->Code;
        } else {
            return ''; // Jika tidak ditemukan, bisa dikembalikan null atau nilai default
        }
    }

}
