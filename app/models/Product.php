<?php

require_once 'core/Model.php';
require_once 'core/Storage.php';

class Product extends Model
{
    protected $table = 'products';

    /**
     * Image path
     */
    const IMAGE_PATH = 'products';

    /**
     * Fillable fields
     */
    protected $fillable = [
        'name',
        'image',
        'slug',
        'description',
        'price',
        'stock',
        'category_id',
    ];

    /**
     * Guarded fields
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the category of the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    /**
     * Get image URL
     */
    public function getImageUrl()
    {
        if ($this->image) {
            return Storage::url(self::IMAGE_PATH . '/' . $this->image);
        }
        
        // Default image jika tidak ada
        return Storage::url('default/product-placeholder.jpg');
    }
    
    /**
     * Upload image untuk product
     */
    public function uploadImage($file, $options = [])
    {
        $defaultOptions = [
            'allowed_types' => Storage::getAllowedTypes('image'),
            'max_size' => 2097152, // 2MB
            'resize' => [
                'width' => 800,
                'height' => 600,
                'quality' => 85
            ]
        ];
        
        $options = array_merge($defaultOptions, $options);
        
        $result = Storage::upload($file, self::IMAGE_PATH, $options);
        
        if ($result['success']) {
            // Hapus image lama jika ada
            if ($this->image) {
                Storage::delete(self::IMAGE_PATH . '/' . $this->image);
            }
            
            // Update image field
            $this->image = $result['filename'];
            $this->save();
        }
        
        return $result;
    }
    
    /**
     * Delete image
     */
    public function deleteImage()
    {
        if ($this->image) {
            $deleted = Storage::delete(self::IMAGE_PATH . '/' . $this->image);
            if ($deleted) {
                $this->image = null;
                $this->save();
            }
            return $deleted;
        }
        
        return false;
    }
    
    /**
     * Get formatted price
     */
    public function getFormattedPrice()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
    
    /**
     * Check if product is in stock
     */
    public function isInStock()
    {
        return $this->stock > 0;
    }
}

?>