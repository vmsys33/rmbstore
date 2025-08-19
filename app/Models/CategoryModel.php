<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'slug', 'description', 'image', 'category_icon', 'parent_id', 'sort_order', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required|min_length[2]|max_length[255]|is_unique[categories.name,id,{id}]',
        'slug' => 'required|min_length[2]|max_length[255]|is_unique[categories.slug,id,{id}]',
        'status' => 'required|in_list[active,inactive]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSlug'];
    protected $beforeUpdate   = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (!isset($data['data']['name'])) {
            return $data;
        }

        $name = $data['data']['name'];
        $slug = url_title($name, '-', true);
        
        // Ensure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->where('slug', $slug)->where('id !=', $data['id'] ?? 0)->first()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        $data['data']['slug'] = $slug;
        return $data;
    }

    public function getActiveCategories()
    {
        return $this->where('status', 'active')
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }

    public function getParentCategories()
    {
        return $this->where('status', 'active')
                    ->where('parent_id IS NULL')
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }

    public function getSubCategories(int $parentId)
    {
        return $this->where('status', 'active')
                    ->where('parent_id', $parentId)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }

    public function getCategoryTree()
    {
        $categories = $this->getActiveCategories();
        return $this->buildTree($categories);
    }

    private function buildTree(array $categories, $parentId = null)
    {
        $tree = [];
        
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $children = $this->buildTree($categories, $category['id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $tree[] = $category;
            }
        }
        
        return $tree;
    }

    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->where('status', 'active')->first();
    }

    public function getCategoryWithProducts(int $categoryId)
    {
        $category = $this->find($categoryId);
        if (!$category) {
            return null;
        }

        // Load products for this category
        $productModel = new ProductModel();
        $category['products'] = $productModel->getProductsByCategory($categoryId);

        return $category;
    }
}
