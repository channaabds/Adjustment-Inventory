<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserSeeder extends Controller
{
    public function createUsers()
    {
        $userModel = new UserModel();

        $users = [
            [
                'name'     => 'Nihon User',
                'username' => 'nihon',
                'password' => password_hash('nihon', PASSWORD_DEFAULT),
            ],
            [
                'name'     => 'PD01 User',
                'username' => 'pd01',
                'password' => password_hash('1234', PASSWORD_DEFAULT),
            ],
            [
                'name'     => 'PD02 User',
                'username' => 'pd02',
                'password' => password_hash('1234', PASSWORD_DEFAULT),
            ],
        ];

        foreach ($users as $user) {
            if ($userModel->insert($user)) {
                echo "User {$user['name']} created successfully!<br>";
            } else {
                echo "Failed to create user {$user['name']}<br>";
            }
        }
    }
}
