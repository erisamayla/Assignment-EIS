<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $search = $this->request->getGet('search');

        if ($search) {
            $model->like('name', $search)->orLike('email', $search)->orLike('country', $search);
        }

        $data['users'] = $model->findAll();

        return view('user_list', $data);
    }

    public function tambah() {
        helper(['form', 'url']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'gender' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('/user');
        }

        $model = new UserModel();
        $hobbies = $this->request->getPost('hobbies');
        $hobbiesJson = json_encode($hobbies);

        $model->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'hobbies' => $hobbiesJson,
            'country' => $this->request->getPost('country'),
            'status' => $this->request->getPost('status') ? 1 : 0,
        ]);

        return redirect()->to('/user');
    }


    public function editPage($id) {
        // Ada tambahan function
        $model = new UserModel();

        $user = $model->find($id);
        if(!$user) {
            return redirect()->to('/user');
        }

        $data['user'] = $user;
        return view('edit_user', $data);
    }

    public function edit($id) {
        // Hari kamis
        helper(['form', 'url']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'gender' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('/user/editPage/' . $id);
        }

        $model = new UserModel();
        $hobbies = $this->request->getPost('hobbies');
        $hobbiesJson = json_encode($hobbies);

        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'hobbies' => $hobbiesJson,
            'country' => $this->request->getPost('country'),
            'status' => $this->request->getPost('status') ? 1 : 0,
        ]);

        return redirect()->to('/user');
    }

    public function detail($id) {
        // INI TUGAS
        $model = new UserModel();
    
        $user = $model->find($id);
        if (!$user) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan.');
        }
    
        $data['user'] = $user;
        return view('detail_user', $data);
    }
    

    public function delete($id) {
        $model = new UserModel();

        $user = $model->find($id);
        if(!$user) {
            return redirect()->to('/user');
        }

        $model->delete($id);
        return redirect()->to('/user');
    }
}
