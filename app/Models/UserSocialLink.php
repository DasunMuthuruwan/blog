<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocialLink extends Model
{
    protected $fillable = [
        'user_id',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'linkedin_url',
        'twitter_url',
        'github_url'
    ];

}
