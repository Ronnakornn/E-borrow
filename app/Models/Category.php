<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'category_img',
        'status'
    ];
    protected $casts = [
        'status' => ProductStatus::class
    ];

    public function scopeEnabled(Builder $query)
    {
        return $query->whereStatus('enable');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('desktop')
            ->performOnCollections('categories')
            ->width(1025)
            ->height(1200)
            ->sharpen(2)
            ->nonQueued();

        $this->addMediaConversion('mobile')
            ->performOnCollections('categories')
            ->width(320)
            ->height(480)
            ->sharpen(2)
            ->nonQueued();

        $this->addMediaConversion('tablet')
            ->performOnCollections('categories')
            ->width(481)
            ->height(768)
            ->sharpen(2)
            ->nonQueued();
    }
}
