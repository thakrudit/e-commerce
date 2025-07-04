<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'title',
        'handle',
        'description',
        'collection_type',
        'products',
        'rules',
        'image',
        'product_count',
    ];

    protected $casts = [
        'products' => 'array',
        'rules' => 'array',
    ];
}
