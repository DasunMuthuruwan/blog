<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\UserSocialLink;
use App\Notifications\PasswordResetSuccessNotification;
use App\PasswordValidationRuleTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Imanghafoori\PasswordHistory\Rules\NotBeInPasswordHistory;
use Livewire\Component;

class Profile extends Component
{
    use PasswordValidationRuleTrait;

    public $tab = null;
    public string $tablename = 'personal_details';
    protected $queryString = ['tab' => ['keep' => true]];

    // Personal details
    public $name, $email, $username, $bio;

    // Password change
    public $current_password, $password, $password_confirmation;

    // Social links
    public $facebook_url, $instagram_url, $youtube_url, $linkedin_url, $twitter_url, $github_url;

    protected string $serverError;
    protected User $user;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->serverError = config('exception-errors.errors.server-error');
    }

    protected $listeners = [
        'updateProfile' => '$refresh'
    ];

    /**
     * Select active tab
     */
    public function selectTab($tab): void
    {
        $this->tab = $tab;
    }

    /**
     * Initialize component
     */
    public function mount(): void
    {
        $this->tab = request('tab', $this->tablename);
        $this->loadUserData();
    }

    /**
     * Load user data and social links
     */
    protected function loadUserData(): void
    {
        $this->user->load('social_links');

        $this->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'username' => $this->user->username,
            'bio' => $this->user->bio,
        ]);

        if ($this->user->social_links) {
            $this->fill([
                'facebook_url' => $this->user->social_links->facebook_url,
                'instagram_url' => $this->user->social_links->instagram_url,
                'youtube_url' => $this->user->social_links->youtube_url,
                'linkedin_url' => $this->user->social_links->linkedin_url,
                'twitter_url' => $this->user->social_links->twitter_url,
                'github_url' => $this->user->social_links->github_url,
            ]);
        }
    }

    /**
     * Update social media links
     */
    public function updateSocialLinks()
    {
        $validated = $this->validate([
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'github_url' => 'nullable|url'
        ]);

        try {
            $this->user->social_links()->updateOrCreate(
                ['user_id' => $this->user->id],
                $validated
            );

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Social links updated successfully.'
            ]);
        } catch (Exception $e) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    /**
     * Update personal details
     */
    public function updatePersonalDetails()
    {
        $validated = $this->validate([
            'name' => 'required',
            'username' => "required|unique:users,username,{$this->user->id}",
            'bio' => 'nullable'
        ]);

        try {
            $updated = $this->user->update($validated);

            if ($updated) {
                $this->dispatch('showToastr', [
                    'type' => 'info',
                    'message' => 'Personal details updated successfully.'
                ]);
                $this->dispatch('updateTopUserInfo')->to(TopUserInfo::class);
            } else {
                $this->dispatch('showToastr', [
                    'type' => 'error',
                    'message' => $this->serverError
                ]);
            }
        } catch (Exception $e) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    /**
     * Update user password
     */
    public function updatePassword()
    {
        $this->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user->password)) {
                        $fail(__('Your current password does not match our records.'));
                    }
                }
            ],
            'password' => [
                'required',
                NotBeInPasswordHistory::ofUser($this->user),
                'confirmed'
            ] + $this->passwordRules($this->user),
            'password_confirmation' => 'required|min:8'
        ]);

        try {
            $updated = $this->user->update([
                'password' => Hash::make($this->password)
            ]);

            if ($updated) {
                Notification::send($this->user, new PasswordResetSuccessNotification($this->user, $this->password));

                auth()->logout();
                Session::flash('info', 'Your password has been successfully changed. Please login with your new password');
                return $this->redirectRoute('admin.login');
            }

            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        } catch (Exception $e) {
            dd($e);
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.profile', [
            'user' => $this->user
        ]);
    }
}
