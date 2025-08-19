<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'remember_token',
        'reset_token',
        'reset_token_expires',
        'last_login',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'email' => 'required|valid_email|is_unique[admins.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[admin,super_admin]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Name is required',
            'min_length' => 'Name must be at least 3 characters long',
            'max_length' => 'Name cannot exceed 255 characters'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please provide a valid email address',
            'is_unique' => 'This email is already registered'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long'
        ],
        'role' => [
            'required' => 'Role is required',
            'in_list' => 'Invalid role selected'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Invalid status selected'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['hashPassword'];

    /**
     * Hash password before insert/update
     */
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        // Only hash if password is not already hashed
        $passwordInfo = password_get_info($data['data']['password']);
        if (!$passwordInfo['algoName']) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

    /**
     * Get admin by email
     */
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Hash password manually
     */
    public function hashPasswordManually($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Get admin by remember token
     */
    public function getByRememberToken($token)
    {
        return $this->where('remember_token', $token)->first();
    }

    /**
     * Update last login time
     */
    public function updateLastLogin($adminId)
    {
        return $this->update($adminId, ['last_login' => date('Y-m-d H:i:s')]);
    }

    /**
     * Get active admins
     */
    public function getActiveAdmins()
    {
        return $this->where('status', 'active')->findAll();
    }

    /**
     * Check if admin exists
     */
    public function adminExists($email)
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }

    /**
     * Create default admin if none exists
     */
    public function createDefaultAdmin()
    {
        $adminCount = $this->countAllResults();
        
        if ($adminCount === 0) {
            $defaultAdmin = [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => 'admin123',
                'role' => 'super_admin',
                'status' => 'active'
            ];

            return $this->insert($defaultAdmin);
        }

        return false;
    }
}
