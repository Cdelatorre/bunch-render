<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductUser extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->badgeData(),
        );
    }

    public function badgeData(){
        $html = '';

        if($this->status == 'requested'){
            $html = '<span class="badge badge--info px-3 py-2">'.trans('Requested').'</span>';
        }
        elseif($this->status == 'scheduled'){
            $html = '<span class="badge badge--warning px-3 py-2">'.trans('Scheduled').'</span>';
        }elseif($this->status == 'cancelled')
        {
            $html = '<span class="badge badge--danger px-3 py-2">'.trans('Cancelled').'</span>';
        }elseif($this->status == 'completed')
        {
            $html = '<span class="badge badge--success px-3 py-2">'.trans('Completed').'</span>';
        }

        return $html;
    }
}
