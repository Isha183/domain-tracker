<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'domain', 'searched_at'];

    protected $casts = [
        'searched_at' => 'datetime',
    ];
}
