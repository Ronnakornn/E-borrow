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

    protected $with = ['user', 'borrowItems'];

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'borrow_number',
        'description',
        'phone',
        'borrow_date',
        'borrow_date_return',
        'status',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'borrow_date_return' => 'datetime',
        'status' => BorrowStatus::class
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $productItemId = $model->borrowItems->pluck('product_item_id')->toArray();
            ProductItem::whereIn('id', $productItemId)->update(['status_borrow' => 'ready']);

            $productId = $model->borrowItems->pluck('product_id')->toArray();
            $countQuantity = ProductItem::where('status_quantity', 'enabled')->count();
            $countBorrow = ProductItem::where('status_quantity', 'enabled')->where('status_borrow', 'ready')->count();

            Product::whereIn('id', $productId)->update(['quantity' => $countQuantity, 'remain' => $countBorrow]);
        });

        static::updated(function ($model) {
            $status = $model->status;
            $productItemId = $model->borrowItems->pluck('product_item_id')->toArray();

            if ($status == BorrowStatus::Returned || $status === BorrowStatus::Canceled || $status == BorrowStatus::Late) {
                ProductItem::whereIn('id', $productItemId)->update(['status_borrow' => 'ready']);
            } else if($status == BorrowStatus::Pending || $status == BorrowStatus::Confirmed ) {
                ProductItem::whereIn('id', $productItemId)->update(['status_borrow' => 'borrow']);
            }

            $productId = $model->borrowItems->pluck('product_id')->toArray();
            $countQuantity = ProductItem::where('status_quantity', 'enabled')->count();
            $countBorrow = ProductItem::where('status_quantity', 'enabled')->where('status_borrow', 'ready')->count();

            Product::whereIn('id', $productId)->update(['quantity' => $countQuantity, 'remain' => $countBorrow]);
        });

    }

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

   public function productItems()
    {
        return $this->HasMany(ProductItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            BorrowItem::class,
            'borrow_id',
            'product_id',
            'product_name',
        )
            ->withPivot('amount', 'product_name')
            ->withTimestamps();
    }
}
