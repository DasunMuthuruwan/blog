<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSocialLink extends Model
{
    protected $fillable = [
        'facebook_url',
        'instagram_url',
        'linkdin_url',
        'twitter_url',
    ];
}
