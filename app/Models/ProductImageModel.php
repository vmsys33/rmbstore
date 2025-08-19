<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table            = 'product_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'product_id', 'image_path', 'image_name', 'alt_text', 
        'sort_order', 'is_primary', 'status'
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
        'is_primary' => 'permit_empty|in_list[0,1]',
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
    protected $beforeInsert   = ['setDefaultValues'];
    protected $beforeUpdate   = ['setDefaultValues'];

    protected function setDefaultValues(array $data)
    {
        if (!isset($data['data']['sort_order'])) {
            $data['data']['sort_order'] = 0;
        }
        if (!isset($data['data']['is_primary'])) {
            $data['data']['is_primary'] = 0;
        }
        if (!isset($data['data']['status'])) {
            $data['data']['status'] = 'active';
        }
        return $data;
    }

    /**
     * Get all images for a specific product
     */
    public function getProductImages($productId, $status = 'active')
    {
        return $this->where('product_id', $productId)
                   ->where('status', $status)
                   ->orderBy('is_primary', 'DESC')
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }

    /**
     * Get primary image for a product
     */
    public function getPrimaryImage($productId)
    {
        return $this->where('product_id', $productId)
                   ->where('is_primary', 1)
                   ->where('status', 'active')
                   ->first();
    }

    /**
     * Set an image as primary for a product
     */
    public function setPrimaryImage($imageId, $productId)
    {
        // First, remove primary status from all other images of this product
        $this->where('product_id', $productId)
             ->set(['is_primary' => 0])
             ->update();

        // Then set the specified image as primary
        return $this->update($imageId, ['is_primary' => 1]);
    }

    /**
     * Get image count for a product
     */
    public function getImageCount($productId, $status = 'active')
    {
        return $this->where('product_id', $productId)
                   ->where('status', $status)
                   ->countAllResults();
    }

    /**
     * Delete all images for a product
     */
    public function deleteProductImages($productId)
    {
        return $this->where('product_id', $productId)->delete();
    }
}
