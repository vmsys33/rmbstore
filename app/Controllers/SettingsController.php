<?php

namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\SettingsGalleryModel;
use App\Helpers\ImageUploadHelper;

class SettingsController extends BaseController
{
    protected $settingsModel;
    protected $settingsGalleryModel;

    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
        try {
            $this->settingsGalleryModel = new SettingsGalleryModel();
        } catch (\Exception $e) {
            // If settings_gallery table doesn't exist, set to null
            $this->settingsGalleryModel = null;
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Store Settings',
            'subTitle' => 'Manage your store configuration',
            'settings' => $this->settingsModel->getSettings(),
            'gallery' => [] // Initialize as empty array to avoid errors
        ];

        // Try to get gallery data if table exists
        if ($this->settingsGalleryModel) {
            try {
                $data['gallery'] = $this->settingsGalleryModel->getAllGallery();
            } catch (\Exception $e) {
                // If table doesn't exist, keep gallery as empty array
                $data['gallery'] = [];
            }
        } else {
            $data['gallery'] = [];
        }

        return view('settings/index', $data);
    }

    public function update()
    {
        try {
            // Validate input - all fields are optional
            $validation = \Config\Services::validation();
            $validation->setRules([
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
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

        // Handle file uploads
        $storeLogo = null;
        $navicon = null;
        $ownerPhoto = null;

        // Upload store logo
        $logoFile = $this->request->getFile('store_logo');
        if ($logoFile && $logoFile->isValid()) {
            $uploadResult = ImageUploadHelper::uploadSettingsImage($logoFile, 'logo');
            if ($uploadResult['success']) {
                $storeLogo = $uploadResult['path'];
            } else {
                return redirect()->back()->withInput()->with('error', 'Store logo: ' . $uploadResult['message']);
            }
        }

        // Upload navicon
        $naviconFile = $this->request->getFile('navicon');
        if ($naviconFile && $naviconFile->isValid()) {
            $uploadResult = ImageUploadHelper::uploadSettingsImage($naviconFile, 'navicon');
            if ($uploadResult['success']) {
                $navicon = $uploadResult['path'];
            } else {
                return redirect()->back()->withInput()->with('error', 'Navigation icon: ' . $uploadResult['message']);
            }
        }

        // Upload owner photo
        $ownerFile = $this->request->getFile('owner_photo');
        if ($ownerFile && $ownerFile->isValid()) {
            $uploadResult = ImageUploadHelper::uploadSettingsImage($ownerFile, 'owner');
            if ($uploadResult['success']) {
                $ownerPhoto = $uploadResult['path'];
            } else {
                return redirect()->back()->withInput()->with('error', 'Owner photo: ' . $uploadResult['message']);
            }
        }

        // Prepare data - allow null values for all fields
        $data = [
            'store_name' => $this->request->getPost('store_name') ?: null,
            'admin_name' => $this->request->getPost('admin_name') ?: null,
            'admin_email' => $this->request->getPost('admin_email') ?: null,
            'about_us' => $this->request->getPost('about_us') ?: null,
            'contact_phone' => $this->request->getPost('contact_phone') ?: null,
            'contact_address' => $this->request->getPost('contact_address') ?: null,
            'social_facebook' => $this->request->getPost('social_facebook') ?: null,
            'social_instagram' => $this->request->getPost('social_instagram') ?: null,
            'social_twitter' => $this->request->getPost('social_twitter') ?: null,
            'currency' => $this->request->getPost('currency') ?: null,
            'tax_rate' => $this->request->getPost('tax_rate') ?: null,
            'shipping_cost' => $this->request->getPost('shipping_cost') ?: null,
            'business_hours' => $this->request->getPost('business_hours') ?: null,
            'timezone' => $this->request->getPost('timezone') ?: null,
        ];

        // Only update image fields if new files were uploaded
        if ($storeLogo) {
            $data['store_logo'] = $storeLogo;
        }
        if ($navicon) {
            $data['navicon'] = $navicon;
        }
        if ($ownerPhoto) {
            $data['owner_photo'] = $ownerPhoto;
        }

        // Save settings
        $result = $this->settingsModel->saveSettings($data);
        
        if (!$result) {
            log_message('error', 'Settings save failed: ' . json_encode($data));
            return redirect()->back()->withInput()->with('error', 'Failed to save settings');
        }

        // Refresh currency cache after settings update
        try {
            \App\Services\CurrencyService::getInstance()->refresh();
            \App\Helpers\CurrencyHelper::clearCache();
        } catch (\Exception $e) {
            log_message('warning', 'Failed to refresh currency cache: ' . $e->getMessage());
        }

        log_message('info', 'Settings saved successfully: ' . json_encode($data));
        return redirect()->to('/admin/settings')->with('success', 'Settings updated successfully');
        } catch (\Exception $e) {
            log_message('error', 'Settings update error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating settings: ' . $e->getMessage());
        }
    }

    public function addGalleryImage()
    {
        // Check if gallery model exists
        if (!$this->settingsGalleryModel) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gallery functionality not available'
            ]);
        }

        // Check gallery limit
        if (!$this->settingsGalleryModel->checkGalleryLimit()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gallery limit reached (maximum 10 images)'
            ]);
        }

        $file = $this->request->getFile('image');
        
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No valid image file provided'
            ]);
        }

        $uploadResult = ImageUploadHelper::uploadSettingsImage($file, 'gallery');
        
        if (!$uploadResult['success']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $uploadResult['message']
            ]);
        }

        $galleryData = [
            'image_path' => $uploadResult['path'],
            'image_name' => $file->getClientName(),
            'alt_text' => $file->getClientName(),
            'sort_order' => $this->settingsGalleryModel->getNextSortOrder(),
            'status' => 'active'
        ];

        $imageId = $this->settingsGalleryModel->insert($galleryData);
        
        if (!$imageId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to save gallery image'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Gallery image added successfully',
            'image' => [
                'id' => $imageId,
                'path' => $uploadResult['path'],
                'name' => $file->getClientName()
            ]
        ]);
    }

    public function deleteGalleryImage($id)
    {
        if (!$this->settingsGalleryModel) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gallery functionality not available'
            ]);
        }

        $image = $this->settingsGalleryModel->find($id);
        
        if (!$image) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Image not found'
            ]);
        }

        // Delete file from server
        if (file_exists(FCPATH . $image['image_path'])) {
            unlink(FCPATH . $image['image_path']);
        }

        // Delete from database
        $result = $this->settingsGalleryModel->delete($id);
        
        if (!$result) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete image'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Gallery image deleted successfully'
        ]);
    }

    public function reorderGallery()
    {
        if (!$this->settingsGalleryModel) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gallery functionality not available'
            ]);
        }

        $imageIds = $this->request->getJSON(true);
        
        if (!is_array($imageIds)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid data provided'
            ]);
        }

        $result = $this->settingsGalleryModel->reorderGallery($imageIds);
        
        if (!$result) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to reorder gallery'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Gallery reordered successfully'
        ]);
    }
}
