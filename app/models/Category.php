<?php

require_once 'core/Model.php';

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
    ];
    
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];    

    /**
     * Get all products in this category
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}

?>