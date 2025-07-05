<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role'];
    protected $returnType = 'array';
    protected $useTimestamps = true;
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    // Aturan validasi
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
        'password' => 'required|min_length[3]|max_length[255]',
        'role' => 'required|in_list[PIC,LEADERMFG1,LEADERMFG2,LEADERQC,MFG2,MFG1,IT,USER,PIC2,CS]'  // Contoh role yang valid
    ];


    // Pesan validasi kustom
    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must be at least 3 characters long',
            'max_length' => 'Username cannot exceed 20 characters',
            'is_unique' => 'Username already exists'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long',
            'max_length' => 'Password cannot exceed 255 characters'
        ],
        'role' => [
            'required' => 'Role is required',
            'in_list' => 'Role must be one of the following: admin, PIC, QC, MFG2, MFG1'
        ]
    ];


    // Hash password sebelum menyimpan ke database
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}
