<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table = 'sliders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'title',
        'subtitle',
        'image',
        'button_text',
        'button_url',
        'sort_order',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'image' => 'required',
        'sort_order' => 'integer',
        'is_active' => 'in_list[0,1]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Slider title is required',
            'min_length' => 'Slider title must be at least 3 characters long',
            'max_length' => 'Slider title cannot exceed 255 characters'
        ],
        'image' => [
            'required' => 'Slider image is required'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get all active sliders ordered by sort_order
     */
    public function getActiveSliders()
    {
        return $this->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Get all sliders for admin management
     */
    public function getAllSliders()
    {
        return $this->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get slider by ID
     */
    public function getSliderById($id)
    {
        return $this->find($id);
    }

    /**
     * Update slider status
     */
    public function updateStatus($id, $status)
    {
        return $this->update($id, ['is_active' => $status]);
    }

    /**
     * Update sort order
     */
    public function updateSortOrder($id, $sortOrder)
    {
        return $this->update($id, ['sort_order' => $sortOrder]);
    }

    /**
     * Get next sort order
     */
    public function getNextSortOrder()
    {
        $result = $this->selectMax('sort_order')->first();
        return ($result['sort_order'] ?? 0) + 1;
    }
}
