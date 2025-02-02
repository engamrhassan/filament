<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tags' => 'array',
    ];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
