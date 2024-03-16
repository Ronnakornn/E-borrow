<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BorrowItem extends Model
{
    use HasFactory;

    protected $with = ['product'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'borrow_id',
        'product_id',
        'amount',
        'product_name'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $productId = $model->pluck('product_id')->toArray();
            Product::whereIn('id', $productId)->update(['status' => 'borrow']);
        });

        // static::deleted(function ($model) {
        //     dd($model->product);
        //     $productId = $model->pluck('product_id')->toArray();
        //     Product::whereIn('id', $productId)->update(['status' => 'ready']);
        // });
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
}
