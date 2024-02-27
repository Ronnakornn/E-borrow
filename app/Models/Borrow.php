<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\BorrowStatus;

class Borrow extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'borrow_number',
        'description',
        'name',
        'borrow_date',
        'borrow_date_return',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'borrow_date_return' => 'datetime',
        'status' => BorrowStatus::class
    ];

    /**
     * Get the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the borrowItems
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function borrowItems()
    {
        return $this->HasMany(BorrowItem::class);
    }
    
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            BorrowItem::class,
            'borrow_id',
            'product_id'
        )
            ->withPivot('amount')
            ->withTimestamps();
    }
}
