<?php

namespace App\Models;

use App\Enums\ProductItemBorrowStatus;
use App\Enums\ProductItemQuantityStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    use HasFactory;

    protected $table = 'product_item';

    protected $fillable = [
        'product_id',
        'sku',
        'status_quantity',
        'status_borrow',
        'remark',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status_quantity' => ProductItemQuantityStatus::class,
        'status_borrow' => ProductItemBorrowStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $productId = $model->pluck('product_id')->toArray();

            $countQuantity = $model->where('status_quantity', 'enabled')->count();
            $countBorrow = $model->where('status_quantity', 'enabled')->where('status_borrow', 'ready')->count();

            Product::whereIn('id', $productId)->update(['quantity' => $countQuantity, 'remain' => $countBorrow]);
        });

        static::deleted(function ($model) {
            $countQuantity = $model->where('status_quantity', 'enabled')->count();
            $countBorrow = $model->where('status_quantity', 'enabled')->where('status_borrow', 'ready')->count();

            Product::where('id', $model->product_id)->update(['quantity' => (int)$countQuantity, 'remain' => (int)$countBorrow]);
        });

        static::updated(function ($model) {
            $countQuantity = $model->where('status_quantity', 'enabled')->count();
            $countBorrow = $model->where('status_quantity', 'enabled')->where('status_borrow', 'ready')->count();

            Product::where('id', $model->product_id)->update(['quantity' => (int)$countQuantity, 'remain' => (int)$countBorrow]);
        });
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function borrowItem(){
        return $this->hasMany(BorrowItem::class);
    }
}
