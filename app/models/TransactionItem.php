<?php

require_once 'core/Model.php';

class TransactionItem extends Model
{
    protected $table = 'transaction_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'total_price',
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
    
    /**
     * Get the transaction that this item belongs to
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    
    /**
     * Get the product that this item belongs to
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}