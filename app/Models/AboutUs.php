<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutUs extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content',
        'image',
        'meta_keywords',
        'meta_descriptions'
    ];
}
