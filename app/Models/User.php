<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use App\UserStatus;
use App\UserType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'picture',
        'bio',
        'type',
        'status',
        'last_login',
        'password_changed_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'type' => UserType::class
        ];
    }

    /**
     * Send the password reset notification to the user.
     *
     * @param $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // Triggers a notification with the password reset token using the ResetPasswordNotification class.
        $this->notify(new ResetPasswordNotification($token, $this));
    }

    /**
     * Get the full URL of the user's profile picture.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function picture(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value
                ? "storage/images/users/{$value}" // Return stored user image if available
                : asset("/images/users/default-profile.jpg") // Return default image if no user image exists
        );
    }

    /**
     * Get the type of the user's.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value
        );
    }

    /**
     * Define a relationship to the user's social links.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function social_links(): BelongsTo
    {
        // Establishes a BelongsTo relationship where 'id' of this model maps to 'user_id' in UserSocialLink
        return $this->belongsTo(UserSocialLink::class, 'id', 'user_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }

    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class);
    }
}
