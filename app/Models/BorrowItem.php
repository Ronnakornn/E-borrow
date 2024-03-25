<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BorrowItem extends Model
{
    use HasFactory;

    protected $with = ['product', 'productItem'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'borrow_id',
        'product_id',
        'product_item_id',
        'amount',
        'product_name'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $productItemId = $model->pluck('product_item_id')->toArray();
            ProductItem::whereIn('id', $productItemId)->update(['status_borrow' => 'borrow']);

            $productId = $model->pluck('product_id')->toArray();
            $countQuantity = ProductItem::where('status_quantity', 'enabled')->count();
            $countBorrow = ProductItem::where('status_quantity', 'enabled')->where('status_borrow', 'ready')->count();

            Product::whereIn('id', $productId)->update(['quantity' => $countQuantity, 'remain' => $countBorrow]);
        });

        static::updated(function ($model) {
            ProductItem::where('id', $model->original['product_item_id'])->update(['status_borrow' => 'ready']);
            ProductItem::where('id', $model->changes['product_item_id'])->update(['status_borrow' => 'borrow']);

            $productId = $model->pluck('product_id')->toArray();
            $countQuantity = ProductItem::where('status_quantity', 'enabled')->count();
            $countBorrow = ProductItem::where('status_quantity', 'enabled')->where('status_borrow', 'ready')->count();

            Product::whereIn('id', $productId)->update(['quantity' => $countQuantity, 'remain' => $countBorrow]);

        });

        static::deleted(function ($model) {
            ProductItem::where('id', $model->original['product_item_id'])->update(['status_borrow' => 'ready']);

            $productId = $model->pluck('product_id')->toArray();
            $countQuantity = ProductItem::where('status_quantity', 'enabled')->count();
            $countBorrow = ProductItem::where('status_quantity', 'enabled')->where('status_borrow', 'ready')->count();

            Product::whereIn('id', $productId)->update(['quantity' => $countQuantity, 'remain' => $countBorrow]);
        });
    }

    /**
     * Get the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }

   /**
     * Get the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productItem()
    {
        return $this->belongsTo(ProductItem::class);

    }

}
