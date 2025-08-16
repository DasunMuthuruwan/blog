<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Ads extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'url',
        'type',
        'image',
        'start_at',
        'end_at',
        'is_default'
    ];

    /**
     * Format the startAt attribute to 'Y-m-d'.
     * This accessor ensures that whenever the created_at value is retrieved,
     * @return Attribute
     * 
     * it will be returned in the format 'YYYY-MM-DD HH:MM:SS'.
     */
    protected function startAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->timezone(config('app.timezone'))->format('Y-m-d'),
        );
    }

    /**
     * Format the end_at attribute to 'Y-m-d'.
     * This accessor ensures that whenever the end_at value is retrieved,
     * 
     * @return Attribute
     * it will be returned in the format 'YYYY-MM-DD HH:MM:SS'.
     */
    protected function endAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->timezone(config('app.timezone'))->format('Y-m-d'),
        );
    }
}
