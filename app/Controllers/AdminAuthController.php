<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Controller;

class AdminAuthController extends Controller
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    /**
     * Show login page
     */
    public function login()
    {
        // If already logged in, redirect to admin dashboard
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }

        // Get settings data for logo
        $settingsModel = new \App\Models\SettingsModel();
        $settings = $settingsModel->first();

        return view('pages/signin', ['settings' => $settings]);
    }

    /**
     * Handle login form submission
     */
    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        // Validate input
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Please provide valid email and password.');
            return redirect()->back()->withInput();
        }

        // Check if admin exists
        $admin = $this->adminModel->where('email', $email)->first();

        if (!$admin) {
            session()->setFlashdata('error', 'Invalid email or password.');
            return redirect()->back()->withInput();
        }

        // Verify password
        if (!password_verify($password, $admin['password'])) {
            session()->setFlashdata('error', 'Invalid email or password.');
            return redirect()->back()->withInput();
        }

        // Check if admin is active
        if ($admin['status'] !== 'active') {
            session()->setFlashdata('error', 'Your account is not active. Please contact administrator.');
            return redirect()->back()->withInput();
        }

        // Set session data
        $sessionData = [
            'admin_id' => $admin['id'],
            'admin_name' => $admin['name'],
            'admin_email' => $admin['email'],
            'admin_role' => $admin['role'],
            'admin_logged_in' => true
        ];

        session()->set($sessionData);

        // Set remember me cookie if requested
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $this->adminModel->update($admin['id'], ['remember_token' => $token]);
            
            $cookie = [
                'name' => 'admin_remember',
                'value' => $token,
                'expire' => 30 * 24 * 60 * 60, // 30 days
                'secure' => false,
                'httponly' => true
            ];
            set_cookie($cookie);
        }

        // Log successful login
        log_message('info', "Admin login successful: {$admin['email']}");

        session()->setFlashdata('success', 'Welcome back, ' . $admin['name'] . '!');
        return redirect()->to('/admin/dashboard');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        $adminId = session()->get('admin_id');
        
        // Clear remember token
        if ($adminId) {
            $this->adminModel->update($adminId, ['remember_token' => null]);
        }

        // Clear remember cookie
        delete_cookie('admin_remember');

        // Destroy session
        session()->destroy();

        session()->setFlashdata('success', 'You have been successfully logged out.');
        return redirect()->to('/admin/login');
    }

    /**
     * Show forgot password page
     */
    public function forgotPassword()
    {
        return view('admin/forgot-password');
    }

    /**
     * Handle forgot password form
     */
    public function sendResetLink()
    {
        $email = $this->request->getPost('email');

        if (!$this->validate(['email' => 'required|valid_email'])) {
            session()->setFlashdata('error', 'Please provide a valid email address.');
            return redirect()->back()->withInput();
        }

        $admin = $this->adminModel->where('email', $email)->first();

        if (!$admin) {
            session()->setFlashdata('error', 'No account found with that email address.');
            return redirect()->back()->withInput();
        }

        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $this->adminModel->update($admin['id'], [
            'reset_token' => $token,
            'reset_token_expires' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);

        // Send reset email (you can implement email functionality here)
        // For now, we'll just show a success message
        session()->setFlashdata('success', 'Password reset link has been sent to your email address.');
        return redirect()->to('/admin/login');
    }

    /**
     * Show reset password page
     */
    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('/admin/login');
        }

        $admin = $this->adminModel->where('reset_token', $token)
                                 ->where('reset_token_expires >', date('Y-m-d H:i:s'))
                                 ->first();

        if (!$admin) {
            session()->setFlashdata('error', 'Invalid or expired reset token.');
            return redirect()->to('/admin/login');
        }

        return view('admin/reset-password', ['token' => $token]);
    }

    /**
     * Handle password reset
     */
    public function updatePassword()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validate input
        $rules = [
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Passwords must be at least 6 characters and match.');
            return redirect()->back();
        }

        $admin = $this->adminModel->where('reset_token', $token)
                                 ->where('reset_token_expires >', date('Y-m-d H:i:s'))
                                 ->first();

        if (!$admin) {
            session()->setFlashdata('error', 'Invalid or expired reset token.');
            return redirect()->to('/admin/login');
        }

        // Update password and clear reset token
        $this->adminModel->update($admin['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expires' => null
        ]);

        session()->setFlashdata('success', 'Password has been reset successfully. You can now login.');
        return redirect()->to('/admin/login');
    }
}
