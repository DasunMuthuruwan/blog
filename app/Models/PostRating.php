<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostRating extends Model
{
    protected $fillable = ['post_id', 'user_id', 'ip_address', 'rating'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
