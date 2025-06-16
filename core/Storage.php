<?php

/**
 * Storage Class - File Upload Management
 * 
 * Class untuk menangani upload file ke folder storage
 * Mirip dengan Laravel Storage tapi lebih sederhana
 */

class Storage
{
    /**
     * Base storage path
     */
    private static $basePath = 'storage';
    
    /**
     * Allowed file types
     */
    private static $allowedTypes = [
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'document' => ['pdf', 'doc', 'docx', 'txt'],
        'archive' => ['zip', 'rar', '7z'],
    ];
    
    /**
     * Max file size (in bytes) - default 5MB
     */
    private static $maxFileSize = 5242880;
    
    /**
     * Upload file ke storage
     */
    public static function upload($file, $folder = '', $options = [])
    {
        // Validasi file
        $validation = self::validateFile($file, $options);
        if (!$validation['valid']) {
            return [
                'success' => false,
                'message' => $validation['message']
            ];
        }
        
        // Buat folder jika belum ada
        $uploadPath = self::createPath($folder);
        if (!$uploadPath) {
            return [
                'success' => false,
                'message' => 'Gagal membuat folder upload'
            ];
        }
        
        // Generate nama file unik
        $fileName = self::generateFileName($file, $options);
        $filePath = $uploadPath . '/' . $fileName;
        
        // Upload file
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Resize image jika diperlukan
            if (isset($options['resize']) && self::isImage($file)) {
                self::resizeImage($filePath, $options['resize']);
            }
            
            return [
                'success' => true,
                'message' => 'File berhasil diupload',
                'path' => self::getRelativePath($folder, $fileName),
                'url' => self::getUrl($folder, $fileName),
                'filename' => $fileName
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Gagal mengupload file'
        ];
    }
    
    /**
     * Upload multiple files
     */
    public static function uploadMultiple($files, $folder = '', $options = [])
    {
        $results = [];
        
        foreach ($files as $file) {
            $results[] = self::upload($file, $folder, $options);
        }
        
        return $results;
    }
    
    /**
     * Delete file dari storage
     */
    public static function delete($path)
    {
        $fullPath = self::$basePath . '/' . ltrim($path, '/');
        
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        
        return false;
    }
    
    /**
     * Check apakah file exists
     */
    public static function exists($path)
    {
        $fullPath = self::$basePath . '/' . ltrim($path, '/');
        return file_exists($fullPath);
    }
    
    /**
     * Get URL untuk file
     */
    public static function url($path)
    {
        $baseUrl = self::getBaseUrl();
        return $baseUrl . '/' . self::$basePath . '/' . ltrim($path, '/');
    }
    
    /**
     * Validasi file upload
     */
    private static function validateFile($file, $options = [])
    {
        // Check upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [
                'valid' => false,
                'message' => self::getUploadErrorMessage($file['error'])
            ];
        }
        
        // Check file size
        $maxSize = $options['max_size'] ?? self::$maxFileSize;
        if ($file['size'] > $maxSize) {
            $maxSizeMB = round($maxSize / 1024 / 1024, 2);
            return [
                'valid' => false,
                'message' => "Ukuran file terlalu besar. Maksimal {$maxSizeMB}MB"
            ];
        }
        
        // Check file type
        if (isset($options['allowed_types'])) {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $options['allowed_types'])) {
                return [
                    'valid' => false,
                    'message' => 'Tipe file tidak diizinkan'
                ];
            }
        }
        
        return ['valid' => true];
    }
    
    /**
     * Buat path folder
     */
    private static function createPath($folder)
    {
        $path = self::$basePath;
        
        if (!empty($folder)) {
            $path .= '/' . trim($folder, '/');
        }
        
        if (!is_dir($path)) {
            return mkdir($path, 0755, true) ? $path : false;
        }
        
        return $path;
    }
    
    /**
     * Generate nama file unik
     */
    private static function generateFileName($file, $options = [])
    {
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (isset($options['name'])) {
            return $options['name'] . '.' . $extension;
        }
        
        // Generate unique name
        $timestamp = time();
        $random = mt_rand(1000, 9999);
        
        return $timestamp . '_' . $random . '.' . $extension;
    }
    
    /**
     * Check apakah file adalah image
     */
    private static function isImage($file)
    {
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        return in_array($extension, self::$allowedTypes['image']);
    }
    
    /**
     * Resize image
     */
    private static function resizeImage($filePath, $dimensions)
    {
        if (!extension_loaded('gd')) {
            return false;
        }
        
        $width = $dimensions['width'] ?? 800;
        $height = $dimensions['height'] ?? null;
        $quality = $dimensions['quality'] ?? 80;
        
        // Get image info
        $imageInfo = getimagesize($filePath);
        if (!$imageInfo) {
            return false;
        }
        
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];
        $imageType = $imageInfo[2];
        
        // Calculate new dimensions
        if ($height === null) {
            $height = ($originalHeight * $width) / $originalWidth;
        }
        
        // Create image resource
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($filePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($filePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($filePath);
                break;
            default:
                return false;
        }
        
        // Create new image
        $newImage = imagecreatetruecolor($width, $height);
        
        // Preserve transparency for PNG and GIF
        if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $width, $height, $transparent);
        }
        
        // Resize
        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
        
        // Save resized image
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($newImage, $filePath, $quality);
                break;
            case IMAGETYPE_PNG:
                imagepng($newImage, $filePath);
                break;
            case IMAGETYPE_GIF:
                imagegif($newImage, $filePath);
                break;
        }
        
        // Clean up
        imagedestroy($source);
        imagedestroy($newImage);
        
        return true;
    }
    
    /**
     * Get relative path
     */
    private static function getRelativePath($folder, $fileName)
    {
        if (empty($folder)) {
            return $fileName;
        }
        
        return trim($folder, '/') . '/' . $fileName;
    }
    
    /**
     * Get full URL
     */
    private static function getUrl($folder, $fileName)
    {
        $baseUrl = self::getBaseUrl();
        $relativePath = self::getRelativePath($folder, $fileName);
        
        return $baseUrl . '/' . self::$basePath . '/' . $relativePath;
    }
    
    /**
     * Get base URL
     */
    private static function getBaseUrl()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
        $basePath = dirname($scriptName);
        
        if ($basePath === '/') {
            $basePath = '';
        }
        
        return $protocol . '://' . $host . $basePath;
    }
    
    /**
     * Get upload error message
     */
    private static function getUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'File terlalu besar (melebihi upload_max_filesize)';
            case UPLOAD_ERR_FORM_SIZE:
                return 'File terlalu besar (melebihi MAX_FILE_SIZE)';
            case UPLOAD_ERR_PARTIAL:
                return 'File hanya terupload sebagian';
            case UPLOAD_ERR_NO_FILE:
                return 'Tidak ada file yang diupload';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Folder temporary tidak ditemukan';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Gagal menulis file ke disk';
            case UPLOAD_ERR_EXTENSION:
                return 'Upload dihentikan oleh ekstensi PHP';
            default:
                return 'Error upload tidak dikenal';
        }
    }
    
    /**
     * Get allowed file types
     */
    public static function getAllowedTypes($category = null)
    {
        if ($category && isset(self::$allowedTypes[$category])) {
            return self::$allowedTypes[$category];
        }
        
        return self::$allowedTypes;
    }
    
    /**
     * Set max file size
     */
    public static function setMaxFileSize($size)
    {
        self::$maxFileSize = $size;
    }
    
    /**
     * Get file size in human readable format
     */
    public static function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}

?> 