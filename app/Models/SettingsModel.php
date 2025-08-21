<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'store_name',
        'store_logo',
        'navicon',
        'admin_name',
        'admin_email',
        'about_us',
        'owner_photo',
        'contact_phone',
        'contact_address',
        'social_facebook',
        'social_instagram',
        'social_twitter',
        'currency',
        'tax_rate',
        'shipping_cost',
        'business_hours',
        'timezone'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation - all fields are optional
    protected $validationRules = [
        'store_name' => 'permit_empty|min_length[3]|max_length[255]',
        'admin_name' => 'permit_empty|min_length[3]|max_length[255]',
        'admin_email' => 'permit_empty|valid_email|max_length[255]',
        'contact_phone' => 'permit_empty|max_length[50]',
        'social_facebook' => 'permit_empty|valid_url|max_length[255]',
        'social_instagram' => 'permit_empty|valid_url|max_length[255]',
        'social_twitter' => 'permit_empty|valid_url|max_length[255]',
        'currency' => 'permit_empty|in_list[USD,EUR,GBP,JPY,CAD,AUD,CHF,CNY,INR,PHP]',
        'tax_rate' => 'permit_empty|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        'shipping_cost' => 'permit_empty|decimal|greater_than_equal_to[0]',
        'business_hours' => 'permit_empty|max_length[255]',
        'timezone' => 'permit_empty|max_length[50]',
    ];

    protected $validationMessages = [
        'store_name' => [
            'min_length' => 'Store name must be at least 3 characters long',
            'max_length' => 'Store name cannot exceed 255 characters',
        ],
        'admin_name' => [
            'min_length' => 'Admin name must be at least 3 characters long',
            'max_length' => 'Admin name cannot exceed 255 characters',
        ],
        'admin_email' => [
            'valid_email' => 'Please enter a valid email address',
            'max_length' => 'Admin email cannot exceed 255 characters',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get the first (and only) settings record
     */
    public function getSettings()
    {
        return $this->first();
    }

    /**
     * Create or update settings
     */
    public function saveSettings($data)
    {
        $existing = $this->first();
        
        if ($existing) {
            // Update existing settings
            return $this->update($existing['id'], $data);
        } else {
            // Create new settings
            return $this->insert($data);
        }
    }
}
