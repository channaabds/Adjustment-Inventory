<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Register extends Controller
{
    public function index()
    {
        helper(['form']);
        return view('register');
    }

    public function save()
    {
        helper(['form']);
        
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'password' => 'required|min_length[6]|max_length[255]',
            'role' => 'required|in_list[LEADERMFG2,LEADERMFG1,PIC,PIC2,QC,MFG2,MFG1,IT,USER]',
            'confpassword' => 'matches[password]'
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'username' => $this->request->getVar('username'),
                'role' => $this->request->getVar('role'),
                'password' => $this->request->getVar('password') // password di-hash di model
            ];
            $model->save($data);
            return redirect()->to(base_url('/login'));
        } else {
            $data['validation'] = $this->validator;
            return view('register', $data);
        }
    }
}
