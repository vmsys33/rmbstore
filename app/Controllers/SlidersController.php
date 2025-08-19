<?php

namespace App\Controllers;

use App\Models\SliderModel;
use App\Models\SettingsModel;

class SlidersController extends BaseController
{
    protected $sliderModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->sliderModel = new SliderModel();
        $this->settingsModel = new SettingsModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Sliders',
            'subTitle' => 'Manage your homepage sliders',
            'sliders' => $this->sliderModel->getAllSliders(),
            'settings' => $this->settingsModel->getSettings()
        ];

        return view('sliders/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Slider',
            'subTitle' => 'Create a new homepage slider',
            'settings' => $this->settingsModel->getSettings()
        ];

        return view('sliders/create', $data);
    }

    public function store()
    {
        // Validate input
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'subtitle' => 'permit_empty|max_length[500]',
            'button_text' => 'permit_empty|max_length[100]',
            'button_url' => 'permit_empty|valid_url',
            'sort_order' => 'permit_empty|integer',
            'is_active' => 'permit_empty|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle image upload
        $image = $this->request->getFile('image');
        $imagePath = '';

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/sliders', $newName);
            $imagePath = 'uploads/sliders/' . $newName;
        } else {
            return redirect()->back()->withInput()->with('error', 'Please upload a valid image.');
        }

        // Prepare data
        $data = [
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'image' => $imagePath,
            'button_text' => $this->request->getPost('button_text'),
            'button_url' => $this->request->getPost('button_url'),
            'sort_order' => $this->request->getPost('sort_order') ?: $this->sliderModel->getNextSortOrder(),
            'is_active' => $this->request->getPost('is_active') ?: 1
        ];

        // Save slider
        if ($this->sliderModel->insert($data)) {
            return redirect()->to('/admin/sliders')->with('success', 'Slider created successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create slider.');
        }
    }

    public function view($id)
    {
        $slider = $this->sliderModel->getSliderById($id);
        
        if (!$slider) {
            return redirect()->to('/admin/sliders')->with('error', 'Slider not found.');
        }

        $data = [
            'title' => 'View Slider',
            'subTitle' => 'Slider details',
            'slider' => $slider,
            'settings' => $this->settingsModel->getSettings()
        ];

        return view('sliders/view', $data);
    }

    public function edit($id)
    {
        $slider = $this->sliderModel->getSliderById($id);
        
        if (!$slider) {
            return redirect()->to('/admin/sliders')->with('error', 'Slider not found.');
        }

        $data = [
            'title' => 'Edit Slider',
            'subTitle' => 'Update slider information',
            'slider' => $slider,
            'settings' => $this->settingsModel->getSettings()
        ];

        return view('sliders/edit', $data);
    }

    public function update($id)
    {
        $slider = $this->sliderModel->getSliderById($id);
        
        if (!$slider) {
            return redirect()->to('/admin/sliders')->with('error', 'Slider not found.');
        }

        // Validate input
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'subtitle' => 'permit_empty|max_length[500]',
            'button_text' => 'permit_empty|max_length[100]',
            'button_url' => 'permit_empty|valid_url',
            'sort_order' => 'permit_empty|integer',
            'is_active' => 'permit_empty|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle image upload
        $image = $this->request->getFile('image');
        $imagePath = $slider['image']; // Keep existing image by default

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/sliders', $newName);
            $imagePath = 'uploads/sliders/' . $newName;
            
            // Delete old image if exists
            if ($slider['image'] && file_exists(ROOTPATH . 'public/' . $slider['image'])) {
                unlink(ROOTPATH . 'public/' . $slider['image']);
            }
        }

        // Prepare data
        $data = [
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'image' => $imagePath,
            'button_text' => $this->request->getPost('button_text'),
            'button_url' => $this->request->getPost('button_url'),
            'sort_order' => $this->request->getPost('sort_order') ?: $slider['sort_order'],
            'is_active' => $this->request->getPost('is_active') ?: $slider['is_active']
        ];

        // Update slider
        if ($this->sliderModel->update($id, $data)) {
            return redirect()->to('/admin/sliders')->with('success', 'Slider updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update slider.');
        }
    }

    public function delete($id)
    {
        $slider = $this->sliderModel->getSliderById($id);
        
        if (!$slider) {
            return redirect()->to('/admin/sliders')->with('error', 'Slider not found.');
        }

        // Delete image file
        if ($slider['image'] && file_exists(ROOTPATH . 'public/' . $slider['image'])) {
            unlink(ROOTPATH . 'public/' . $slider['image']);
        }

        // Delete slider
        if ($this->sliderModel->delete($id)) {
            return redirect()->to('/admin/sliders')->with('success', 'Slider deleted successfully.');
        } else {
            return redirect()->to('/admin/sliders')->with('error', 'Failed to delete slider.');
        }
    }

    public function toggleStatus($id)
    {
        $slider = $this->sliderModel->getSliderById($id);
        
        if (!$slider) {
            return redirect()->to('/admin/sliders')->with('error', 'Slider not found.');
        }

        $newStatus = $slider['is_active'] ? 0 : 1;
        
        if ($this->sliderModel->updateStatus($id, $newStatus)) {
            $statusText = $newStatus ? 'activated' : 'deactivated';
            return redirect()->to('/admin/sliders')->with('success', "Slider {$statusText} successfully.");
        } else {
            return redirect()->to('/admin/sliders')->with('error', 'Failed to update slider status.');
        }
    }
}
