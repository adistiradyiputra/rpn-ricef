<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PesertaModel;
use App\Models\OrganizationModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    protected $organizationModel;

    public function __construct()
    {
        $this->organizationModel = new OrganizationModel();
    }

    public function index()
    {
        return view('v_login');
    }

    public function auth()
    {
        $session = session();
        $userModel = new UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'user_id'   => $user['id'],
                    'username'  => $user['username'],
                    'name'      => $user['name'],
                    'level'     => $user['level'],
                    'puslit'    => $user['puslit'],
                    'logged_in' => true,
                    'user_type' => 'admin' // Mark as admin user
                ];
                $session->set($sessionData);
                return redirect()->to('/pelatihan')->with('message', 'Login berhasil!');
            } else {
                return redirect()->to('/')->with('error', 'Password salah.');
            }
        } else {
            // Try to authenticate from peserta table
            $pesertaModel = new PesertaModel();
            $peserta = $pesertaModel->where('username', $username)->first();
            
            if ($peserta) {
                if (password_verify($password, $peserta['password'])) {
                    // Get the detail_pelatihan and pelatihan info for this peserta
                    $detailPelatihanModel = new \App\Models\DetailPelatihanModel();
                    $pelatihanModel = new \App\Models\PelatihanModel();
                    
                    $detailPelatihan = $detailPelatihanModel->find($peserta['id_detail_pelatihan']);
                    $pelatihan = null;
                    $puslit = null;
                    
                    if ($detailPelatihan) {
                        $pelatihan = $pelatihanModel->find($detailPelatihan['id_pelatihan']);
                        if ($pelatihan) {
                            $puslit = $pelatihan['puslit'];
                        }
                    }
                    
                    $sessionData = [
                        'user_id'   => $peserta['id'],
                        'username'  => $peserta['username'],
                        'name'      => $peserta['nama'],
                        'level'     => 3, // Level 3 for peserta
                        'puslit'    => $puslit,
                        'id_detail_pelatihan' => $peserta['id_detail_pelatihan'],
                        'alamat'    => $peserta['alamat'],
                        'instansi'  => $peserta['instansi'],
                        'telp'      => $peserta['telp'],
                        'logged_in' => true,
                        'user_type' => 'peserta' // Mark as peserta
                    ];
                    $session->set($sessionData);
                    return redirect()->to('/pelatihan')->with('message', 'Login berhasil!');
                } else {
                    return redirect()->to('/')->with('error', 'Password salah.');
                }
            } else {
                return redirect()->to('/')->with('error', 'Username tidak ditemukan.');
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('message', 'Logout berhasil.');
    }
}
