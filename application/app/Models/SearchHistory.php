<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'activities', 'services', 'min_price', 'city', 'max_price', 'search_count', 'search_hash'];

    protected $casts = [
        'activities' => 'array', // Cast JSON to array automatically
        'services' => 'array', // Cast JSON to array automatically
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
