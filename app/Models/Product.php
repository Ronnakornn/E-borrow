<?php

namespace App\Models;

use App\Casts\Json;
use App\Enums\ProductStatus;
use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $with = ['category', 'media'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'description',
        'product_attr',
        'amount',
        'warranty',
        'remark',
        'product_img',
        'type',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'product_attr' => 'json',
        // 'type' => ProductType::class,
        'status' => ProductStatus::class,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowItem()
    {
        return $this->hasMany(BorrowItem::class);
    }

    // public function brand()
    // {
    //     return $this->belongsTo(Brand::class);
    // }

    // public function stocks()
    // {
    //     return $this->belongsToMany(Stock::class, 'stock_product', 'product_id', 'stock_id');
    // }

    // /**
    //  * Get all of the cartItems for the Product
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function cartItems()
    // {
    //     return $this->hasMany(CartItem::class);
    // }

    // /**
    //  * Get all of the orderItem for the Product
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function orderItem()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('desktop')
            ->performOnCollections('products')
            ->width(1025)
            ->height(1200)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('mobile')
            ->performOnCollections('products')
            ->width(320)
            ->height(480)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('tablet')
            ->performOnCollections('products')
            ->width(481)
            ->height(768)
            ->sharpen(10)
            ->nonQueued();
    }
}
