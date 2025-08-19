<?php

namespace App\Controllers;

use App\Models\UserModel;

class UsersController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Users Management',
            'subTitle' => 'Manage your system users',
            'users' => $this->userModel->findAll()
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New User',
            'subTitle' => 'Create a new system user'
        ];

        return view('users/create', $data);
    }

    public function store()
    {
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'role' => 'required|in_list[admin,customer,staff]',
            'status' => 'required|in_list[active,inactive,banned]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Prepare data
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status')
        ];

        // Insert user
        $userId = $this->userModel->insert($data);
        
        if (!$userId) {
            return redirect()->back()->withInput()->with('error', 'Failed to create user');
        }

        return redirect()->to('/users')->with('success', 'User created successfully');
    }

    public function view($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User not found');
        }

        // Remove password from display
        unset($user['password']);

        $data = [
            'title' => 'View User',
            'subTitle' => 'User details',
            'user' => $user
        ];

        return view('users/view', $data);
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User not found');
        }

        // Remove password from display
        unset($user['password']);

        $data = [
            'title' => 'Edit User',
            'subTitle' => 'Update user information',
            'user' => $user
        ];

        return view('users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User not found');
        }

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,' . $id . ']',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'role' => 'required|in_list[admin,customer,staff]',
            'status' => 'required|in_list[active,inactive,banned]'
        ]);

        // Add password validation only if password is provided
        if ($this->request->getPost('password')) {
            $validation->setRules([
                'password' => 'min_length[6]',
                'confirm_password' => 'matches[password]'
            ]);
        }

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Prepare data
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status')
        ];

        // Update password only if provided
        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        // Update user
        $result = $this->userModel->update($id, $data);
        
        if (!$result) {
            return redirect()->back()->withInput()->with('error', 'Failed to update user');
        }

        return redirect()->to('/users')->with('success', 'User updated successfully');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User not found');
        }

        // Prevent deleting the current user
        if ($id == session()->get('user_id')) {
            return redirect()->to('/users')->with('error', 'Cannot delete your own account');
        }

        // Delete user
        $result = $this->userModel->delete($id);
        
        if (!$result) {
            return redirect()->to('/users')->with('error', 'Failed to delete user');
        }

        return redirect()->to('/users')->with('success', 'User deleted successfully');
    }
}
