<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use PharIo\Manifest\Author;

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

    public function authors():BelongsToMany
    {
        return $this->belongsToMany(User::class,'post_user')->withPivot(['order'])->withTimestamps();
    }
}
