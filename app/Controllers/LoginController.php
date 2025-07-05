<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class LoginController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('login');
    }

    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Memeriksa username dan password dari database menggunakan UserModel
        $user = $this->userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Tidak melakukan regenerasi ID sesi
            // Menyimpan informasi sesi pengguna tanpa menghapus data sebelumnya
            session()->set([
                'isLoggedIn' => true,
                'username' => $user['username'],
                'role' => $user['role']
            ]);

            log_message('info', 'Pengguna login: ' . $user['username'] . ' dengan peran: ' . $user['role']);

            // Mengarahkan pengguna sesuai dengan perannya
            switch ($user['role']) {
                case 'PIC':
                case 'LEADERMFG1':
                case 'LEADERMFG2':
                case 'IT':
                case 'PIC2':
                case 'LEADERQC':
                case 'CS':
                    return redirect()->to(base_url('pic/dashboard'));
                case 'MFG1':
                case 'MFG2':
                case 'USER':
                    return redirect()->to(base_url('dashboard'));
                default:
                    return redirect()->to(base_url('login'))->with('message', 'Peran tidak dikenali.');
            }
        } else {
            return redirect()->back()->with('message', 'Username atau Password yang Anda masukkan salah.');
        }
    }


    public function logout()
    {
        // Regenerasi ID sesi sebelum menghancurkan sesi untuk keamanan
        session()->regenerate(true);

        // Menghancurkan sesi
        session()->destroy();
        log_message('info', 'Pengguna logout'); // Logging untuk debugging
        return redirect()->to(base_url('login'));
    }
}
