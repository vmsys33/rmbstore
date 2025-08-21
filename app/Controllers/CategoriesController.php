<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class CategoriesController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Categories Management',
            'subTitle' => 'Manage your product categories',
            'categories' => $this->categoryModel->findAll()
        ];

        return view('categories/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Category',
            'subTitle' => 'Create a new product category'
        ];

        return view('categories/create', $data);
    }

    public function store()
    {
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]|is_unique[categories.name]',
            'description' => 'permit_empty|max_length[500]',
            'status' => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Prepare data
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description') ?: null,
            'status' => $this->request->getPost('status')
        ];

        // Insert category
        $categoryId = $this->categoryModel->insert($data);
        
        if (!$categoryId) {
            return redirect()->back()->withInput()->with('error', 'Failed to create category');
        }

        return redirect()->to('/categories')->with('success', 'Category created successfully');
    }

    public function view($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/categories')->with('error', 'Category not found');
        }

        $data = [
            'title' => 'View Category',
            'subTitle' => 'Category details',
            'category' => $category
        ];

        return view('categories/view', $data);
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/categories')->with('error', 'Category not found');
        }

        $data = [
            'title' => 'Edit Category',
            'subTitle' => 'Update category information',
            'category' => $category
        ];

        return view('categories/edit', $data);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/categories')->with('error', 'Category not found');
        }

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]|is_unique[categories.name,id,' . $id . ']',
            'description' => 'permit_empty|max_length[500]',
            'status' => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Prepare data
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description') ?: null,
            'status' => $this->request->getPost('status')
        ];

        // Update category
        $result = $this->categoryModel->update($id, $data);
        
        if (!$result) {
            return redirect()->back()->withInput()->with('error', 'Failed to update category');
        }

        return redirect()->to('/categories')->with('success', 'Category updated successfully');
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/categories')->with('error', 'Category not found');
        }

        // Check if category has products
        $productModel = new \App\Models\ProductModel();
        $productsCount = $productModel->where('product_category', $id)->countAllResults();
        
        if ($productsCount > 0) {
            return redirect()->to('/categories')->with('error', 'Cannot delete category. It has ' . $productsCount . ' associated products.');
        }

        // Delete category
        $result = $this->categoryModel->delete($id);
        
        if (!$result) {
            return redirect()->to('/categories')->with('error', 'Failed to delete category');
        }

        return redirect()->to('/categories')->with('success', 'Category deleted successfully');
    }
}
