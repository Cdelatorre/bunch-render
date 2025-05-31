<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /* -----------------------------------------------------------------
     |  Casting de campos JSON
     * -----------------------------------------------------------------*/
   protected $casts = [
    'address'         => 'array',   //  ←  ahora obtienes array asociativo
    'billing_address' => 'array',
    'schedules'       => 'array',
    'rates'           => 'array',
    ];


    /* -----------------------------------------------------------------
     |  Relaciones
     * -----------------------------------------------------------------*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getWishlist()
    {
        return $this->hasOne(Wishlist::class, 'product_id', 'id');
    }

    public function productImages()
    {
        /* usa Image, no ProductImage */
        return $this->hasMany(Image::class, 'product_id', 'id')
                    ->orderByDesc('priority');
    }

    public function getServices()
    {
        return $this->hasMany(ServiceProduct::class, 'product_id', 'id');
    }

    public function getCategories()
    {
        return $this->hasMany(CategoryProduct::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productUsers()
    {
        return $this->hasMany(ProductUser::class);
    }

    /* -----------------------------------------------------------------
     |  Accesor para el badge de estado
     * -----------------------------------------------------------------*/
    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => $this->badgeData(),
        );
    }

    private function badgeData(): string
    {
        return match ($this->status) {
            0 => '<span class="badge badge--warning">' . trans('Pending')   . '</span>',
            1 => '<span class="badge badge--success">' . trans('Active')    . '</span>',
            2 => '<span class="badge badge--danger">'  . trans('Expired')   . '</span>',
            3 => '<span class="badge badge--danger">'  . trans('Cancel')    . '</span>',
            4 => '<span class="badge badge--success">' . trans('Delivered') . '</span>',
            default => '',
        };
    }

    /* -----------------------------------------------------------------
     |  Accesor ‘average_rating’ (combina reviews internas + Google)
     * -----------------------------------------------------------------*/
    protected function averageRating(): Attribute
    {
        return new Attribute(
            get: function () {
                $totalReviews   = $this->google_review_count ?? 0;
                $weightedRating = ($this->google_rating ?? 0) * $totalReviews;

                if ($this->user) {
                    $totalReviews   += $this->user->review_count;
                    $weightedRating += ($this->user->avg_review ?? 0) * $this->user->review_count;
                }

                return $totalReviews > 0
                    ? round($weightedRating / $totalReviews, 1)
                    : 0.0;
            },
        );
    }
}
