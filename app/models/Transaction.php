<?php

require_once 'core/Model.php';

class Transaction extends Model
{
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'payment_proof_file',
        'status',
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
     * Get the user who made the transaction
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}