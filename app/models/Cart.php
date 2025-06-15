<?php

require_once 'core/Model.php';

class Cart extends Model
{
    protected $table = 'carts';

    /**
     * Fillable fields
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
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
     * Get the user of the cart
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the product of the cart
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

?>