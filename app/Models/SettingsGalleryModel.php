<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsGalleryModel extends Model
{
    protected $table = 'settings_gallery';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'image_path',
        'image_name',
        'alt_text',
        'sort_order',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'image_path' => 'required|max_length[255]',
        'image_name' => 'required|max_length[255]',
        'alt_text' => 'permit_empty|max_length[255]',
        'sort_order' => 'permit_empty|integer',
        'status' => 'required|in_list[active,inactive]',
    ];

    protected $validationMessages = [
        'image_path' => [
            'required' => 'Image path is required',
            'max_length' => 'Image path cannot exceed 255 characters',
        ],
        'image_name' => [
            'required' => 'Image name is required',
            'max_length' => 'Image name cannot exceed 255 characters',
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be either active or inactive',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get all active gallery images ordered by sort_order
     */
    public function getActiveGallery()
    {
        return $this->where('status', 'active')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Get all gallery images ordered by sort_order
     */
    public function getAllGallery()
    {
        return $this->orderBy('sort_order', 'ASC')->findAll();
    }

    /**
     * Check if gallery has reached maximum limit (10 images)
     */
    public function checkGalleryLimit()
    {
        $count = $this->countAllResults();
        return $count < 10; // Maximum 10 gallery images
    }

    /**
     * Get next sort order
     */
    public function getNextSortOrder()
    {
        $lastImage = $this->orderBy('sort_order', 'DESC')->first();
        return $lastImage ? $lastImage['sort_order'] + 1 : 0;
    }

    /**
     * Reorder gallery images
     */
    public function reorderGallery($imageIds)
    {
        foreach ($imageIds as $index => $imageId) {
            $this->update($imageId, ['sort_order' => $index]);
        }
        return true;
    }
}
