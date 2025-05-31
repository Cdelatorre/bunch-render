<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Review extends Model
{
    use HasFactory;

    public function review()
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

        if($this->status == '0'){
            $html = '<span class="badge badge--danger px-3 py-2">'.trans('Disabled').'</span>';
        }
        elseif($this->status == '1'){
            $html = '<span class="badge badge--success px-3 py-2">'.trans('Enabled').'</span>';
        }

        return $html;
    }
}
