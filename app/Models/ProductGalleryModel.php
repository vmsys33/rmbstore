<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductGalleryModel extends Model
{
    protected $table            = 'product_gallery';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'product_id', 'image_path', 'image_name', 'alt_text', 
        'sort_order', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'product_id' => 'required|integer|is_not_unique[products.id]',
        'image_path' => 'required|max_length[255]',
        'image_name' => 'required|max_length[255]',
        'alt_text'   => 'permit_empty|max_length[255]',
        'sort_order' => 'permit_empty|integer',
        'status'     => 'permit_empty|in_list[active,inactive]',
    ];

    protected $validationMessages   = [
        'product_id' => [
            'required' => 'Product ID is required',
            'integer' => 'Product ID must be a valid integer',
            'is_not_unique' => 'Product ID does not exist in products table',
        ],
        'image_path' => [
            'required' => 'Image path is required',
            'max_length' => 'Image path cannot exceed 255 characters',
        ],
        'image_name' => [
            'required' => 'Image name is required',
            'max_length' => 'Image name cannot exceed 255 characters',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setDefaultValues', 'checkImageLimit'];
    protected $beforeUpdate   = ['setDefaultValues'];

    protected function setDefaultValues(array $data)
    {
        if (!isset($data['data']['sort_order'])) {
            $data['data']['sort_order'] = 0;
        }
        if (!isset($data['data']['status'])) {
            $data['data']['status'] = 'active';
        }
        return $data;
    }

    protected function checkImageLimit(array $data)
    {
        if (isset($data['data']['product_id'])) {
            $productId = $data['data']['product_id'];
            $currentCount = $this->where('product_id', $productId)
                               ->where('status', 'active')
                               ->countAllResults();
            
            if ($currentCount >= 6) {
                throw new \Exception('Maximum 6 gallery images allowed per product');
            }
        }
        return $data;
    }

    /**
     * Get all gallery images for a specific product
     */
    public function getProductGallery($productId, $status = 'active')
    {
        return $this->where('product_id', $productId)
                   ->where('status', $status)
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }

    /**
     * Get gallery image count for a product
     */
    public function getGalleryCount($productId, $status = 'active')
    {
        return $this->where('product_id', $productId)
                   ->where('status', $status)
                   ->countAllResults();
    }

    /**
     * Check if product can have more gallery images
     */
    public function canAddMoreImages($productId)
    {
        $count = $this->getGalleryCount($productId);
        return $count < 6;
    }

    /**
     * Delete all gallery images for a product
     */
    public function deleteProductGallery($productId)
    {
        return $this->where('product_id', $productId)->delete();
    }

    /**
     * Get gallery images with pagination
     */
    public function getGalleryWithPagination($productId, $page = 1, $perPage = 6)
    {
        return $this->where('product_id', $productId)
                   ->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->paginate($perPage, 'default', $page);
    }

    /**
     * Update sort order for gallery images
     */
    public function updateSortOrder($imageId, $newSortOrder)
    {
        return $this->update($imageId, ['sort_order' => $newSortOrder]);
    }

    /**
     * Reorder gallery images
     */
    public function reorderGallery($productId, $imageIds)
    {
        $sortOrder = 1;
        foreach ($imageIds as $imageId) {
            $this->update($imageId, ['sort_order' => $sortOrder]);
            $sortOrder++;
        }
        return true;
    }
}
