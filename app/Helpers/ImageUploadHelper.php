<?php

namespace App\Helpers;

class ImageUploadHelper
{
    /**
     * Upload and process product image
     */
    public static function uploadProductImage($file, $type = 'gallery', $productId = null)
    {
        if (!$file || !$file->isValid()) {
            return ['success' => false, 'message' => 'Invalid file'];
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!in_array($file->getClientMimeType(), $allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and WebP are allowed.'];
        }

        // Validate file size (10MB max)
        $maxSize = 10 * 1024 * 1024; // 10MB
        if ($file->getSize() > $maxSize) {
            return ['success' => false, 'message' => 'File size too large. Maximum 10MB allowed.'];
        }

        // Generate unique filename
        $extension = $file->getClientExtension();
        $filename = uniqid() . '_' . time() . '.' . $extension;

        // Determine upload path based on type
        $uploadPath = self::getUploadPath($type, $productId);
        $fullPath = $uploadPath . '/' . $filename;

        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0755, true)) {
                return ['success' => false, 'message' => 'Failed to create upload directory: ' . $uploadPath];
            }
        }

        // Move uploaded file
        if (!$file->move($uploadPath, $filename)) {
            return ['success' => false, 'message' => 'Failed to upload file to: ' . $uploadPath . '/' . $filename];
        }

        // Resize image based on type
        $resized = self::resizeImage($fullPath, $type);
        if (!$resized) {
            // If resize fails, still return success but with original file
                    return [
            'success' => true,
            'filename' => $filename,
            'path' => 'uploads/products/' . ($type === 'post' ? 'posts' : ($type === 'icon' ? 'icons' : $type)) . '/' . $filename,
            'message' => 'File uploaded but resize failed'
        ];
        }

        return [
            'success' => true,
            'filename' => $filename,
            'path' => 'uploads/products/' . ($type === 'post' ? 'posts' : ($type === 'icon' ? 'icons' : $type)) . '/' . $filename,
            'message' => extension_loaded('gd') ? 'File uploaded successfully' : 'File uploaded successfully (GD extension not available - image not resized)'
        ];
    }

    /**
     * Upload and process settings image
     */
    public static function uploadSettingsImage($file, $type = 'gallery')
    {
        if (!$file || !$file->isValid()) {
            return ['success' => false, 'message' => 'Invalid file'];
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!in_array($file->getClientMimeType(), $allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and WebP are allowed.'];
        }

        // Validate file size (10MB max)
        $maxSize = 10 * 1024 * 1024; // 10MB
        if ($file->getSize() > $maxSize) {
            return ['success' => false, 'message' => 'File size too large. Maximum 10MB allowed.'];
        }

        // Generate unique filename
        $extension = $file->getClientExtension();
        $filename = uniqid() . '_' . time() . '.' . $extension;

        // Determine upload path based on type
        $uploadPath = self::getSettingsUploadPath($type);
        $fullPath = $uploadPath . '/' . $filename;

        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Move uploaded file
        if (!$file->move($uploadPath, $filename)) {
            return ['success' => false, 'message' => 'Failed to upload file'];
        }

        // Resize image based on type
        $resized = self::resizeImage($fullPath, $type);
        if (!$resized) {
            // If resize fails, still return success but with original file
            return [
                'success' => true,
                'filename' => $filename,
                'path' => 'uploads/settings/' . $type . '/' . $filename,
                'message' => 'File uploaded but resize failed'
            ];
        }

        return [
            'success' => true,
            'filename' => $filename,
            'path' => 'uploads/settings/' . $type . '/' . $filename,
            'message' => extension_loaded('gd') ? 'File uploaded successfully' : 'File uploaded successfully (GD extension not available - image not resized)'
        ];
    }

    /**
     * Get upload path based on image type
     */
    private static function getUploadPath($type, $productId = null)
    {
        $basePath = FCPATH . 'uploads/products';
        
        switch ($type) {
            case 'icon':
                return $basePath . '/icons';
            case 'post':
                return $basePath . '/posts';
            case 'gallery':
                $galleryPath = $basePath . '/gallery';
                if ($productId) {
                    $galleryPath .= '/' . $productId;
                }
                return $galleryPath;
            default:
                return $basePath . '/gallery';
        }
    }

    /**
     * Get settings upload path based on image type
     */
    private static function getSettingsUploadPath($type)
    {
        $basePath = FCPATH . 'uploads/settings';
        
        switch ($type) {
            case 'logo':
                return $basePath . '/logo';
            case 'navicon':
                return $basePath . '/navicon';
            case 'owner':
                return $basePath . '/owner';
            case 'gallery':
                return $basePath . '/gallery';
            default:
                return $basePath . '/gallery';
        }
    }

    /**
     * Resize image based on type
     */
    private static function resizeImage($filePath, $type)
    {
        // Check if GD extension is available
        if (!extension_loaded('gd')) {
            // If GD is not available, return true to indicate success without resizing
            return true;
        }

        if (!file_exists($filePath)) {
            return false;
        }

        $imageInfo = getimagesize($filePath);
        if (!$imageInfo) {
            return false;
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $mime = $imageInfo['mime'];

        // Create image resource
        switch ($mime) {
            case 'image/jpeg':
                if (!function_exists('imagecreatefromjpeg')) {
                    return true; // Return true if function doesn't exist
                }
                $source = imagecreatefromjpeg($filePath);
                break;
            case 'image/png':
                if (!function_exists('imagecreatefrompng')) {
                    return true; // Return true if function doesn't exist
                }
                $source = imagecreatefrompng($filePath);
                break;
            case 'image/webp':
                if (!function_exists('imagecreatefromwebp')) {
                    return true; // Return true if function doesn't exist
                }
                $source = imagecreatefromwebp($filePath);
                break;
            default:
                return false;
        }

        if (!$source) {
            return false;
        }

        // Define target dimensions based on type
        $targetDimensions = self::getTargetDimensions($type);
        $targetWidth = $targetDimensions['width'];
        $targetHeight = $targetDimensions['height'];

        // Calculate new dimensions maintaining aspect ratio
        $ratio = min($targetWidth / $width, $targetHeight / $height);
        $newWidth = round($width * $ratio);
        $newHeight = round($height * $ratio);

        // Create new image
        $destination = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG
        if ($mime === 'image/png') {
            imagealphablending($destination, false);
            imagesavealpha($destination, true);
            $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
            imagefill($destination, 0, 0, $transparent);
        }

        // Resize image
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save resized image
        $success = false;
        switch ($mime) {
            case 'image/jpeg':
                $success = imagejpeg($destination, $filePath, 85);
                break;
            case 'image/png':
                $success = imagepng($destination, $filePath, 8);
                break;
            case 'image/webp':
                $success = imagewebp($destination, $filePath, 85);
                break;
        }

        // Clean up
        imagedestroy($source);
        imagedestroy($destination);

        return $success;
    }

    /**
     * Get target dimensions for each image type
     */
    private static function getTargetDimensions($type)
    {
        switch ($type) {
            case 'icon':
                return ['width' => 54, 'height' => 54];
            case 'post':
                return ['width' => 431, 'height' => 467];
            case 'gallery':
                return ['width' => 1200, 'height' => 800];
            case 'logo':
                return ['width' => 300, 'height' => 100];
            case 'navicon':
                return ['width' => 32, 'height' => 32];
            case 'owner':
                return ['width' => 400, 'height' => 400];
            default:
                return ['width' => 800, 'height' => 600];
        }
    }

    /**
     * Delete image file
     */
    public static function deleteImage($filePath)
    {
        $fullPath = FCPATH . $filePath;
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }

    /**
     * Validate image file
     */
    public static function validateImage($file)
    {
        if (!$file || !$file->isValid()) {
            return ['valid' => false, 'message' => 'Invalid file'];
        }

        // Check file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!in_array($file->getClientMimeType(), $allowedTypes)) {
            return ['valid' => false, 'message' => 'Invalid file type. Only JPG, PNG, and WebP are allowed.'];
        }

        // Check file size (10MB max)
        $maxSize = 10 * 1024 * 1024; // 10MB
        if ($file->getSize() > $maxSize) {
            return ['valid' => false, 'message' => 'File size too large. Maximum 10MB allowed.'];
        }

        // Check if GD extension is available for image processing
        if (!extension_loaded('gd')) {
            return ['valid' => true, 'message' => 'File is valid (GD extension not available - images will not be resized)'];
        }

        return ['valid' => true, 'message' => 'File is valid'];
    }
}
