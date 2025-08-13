<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'ip_address',
        'parent_id',
        'comment'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): belongsTo
    {
        return $this->belongsTo(Post::class, 'id');
    }

    // Relationship with replies
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Relationship with likes
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function setCommentAttribute($value)
    {
        $this->attributes['comment'] = strip_tags($value);
    }
}
