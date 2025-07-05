<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Logika login
    }

    public function logout()
    {
        // Logika logout
    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'], // Tambahkan role pengguna
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
    }
}

