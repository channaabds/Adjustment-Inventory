<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class Inventory extends Controller
{
    use ResponseTrait;

    protected $db;

    public function __construct()
    {
        // Koneksi ke SQL Server
        $this->db = \Config\Database::connect('sqlsrv');
    }

    public function getPartNumberToAndWarehouse()
    {
        $partNumberFrom = $this->request->getGet('part_number_from');

        // Debug log
        log_message('debug', 'Part Number From: ' . $partNumberFrom);

        $query = "SELECT T1.Code AS part_number_to, T1.Warehouse AS warehouse_from
                  FROM OITT T0
                  INNER JOIN ITT1 T1 ON T0.Code = T1.Father
                  WHERE T0.Code = ?";

        $result = $this->db->query($query, [$partNumberFrom])->getRowArray();

        // Debug log
        log_message('debug', 'Query Result: ' . json_encode($result));

        if ($result) {
            return $this->response->setJSON($result);
        } else {
            return $this->response->setJSON(['part_number_to' => '', 'warehouse_from' => '']);
        }
    }
}
