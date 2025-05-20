<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('v_user');
    }

    public function getUsers()
    {
        $users = $this->userModel->findAll();
        return $this->response->setJSON(['data' => $users]);
    }

    public function saveUser()
    {
        $data = [
            'name'     => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'created_by' => 1,
            'updated_by' => 1,
        ];

        $this->userModel->save($data);
        return $this->response->setJSON(['success' => true]);
    }

    public function updateUser($id)
    {
        $data = [
            'name'     => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'updated_by' => 1,
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        return $this->response->setJSON(['success' => true]);
    }

    public function deleteUser($id)
    {
        $this->userModel->delete($id);
        return $this->response->setJSON(['success' => true]);
    }
}
