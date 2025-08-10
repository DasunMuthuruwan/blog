<?php

namespace App\Livewire\Admin;

use App\Constants\CacheKeys;
use Exception;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AboutUs extends Component
{
    public $tab = null;
    public string $tablename = 'general_settings';
    protected $queryString = ['tab' => ['keep' => true]];

    // General setting properties
    public $site_title;
    public $site_email;
    public $site_phone;
    public $site_meta_keywords;
    public $site_meta_description;
    public $site_logo;
    public $site_favicon;

    // site social links form properties
    public $facebook_url, $instagram_url, $linkdin_url, $twitter_url;

    protected string $serverError;

    public function __construct()
    {
        $this->serverError = config('exception-errors.errors.server-error');
    }

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
        $this->populateSettings();
    }

    /**
     * Load general settings from database
     */
    protected function populateSettings(): void
    {
        $settings = GeneralSetting::first(); // first() is more semantic than take(1)->first()
        $socialLinks = SiteSocialLink::first();
        if ($settings) {
            $this->fill([
                'site_title' => $settings->site_title,
                'site_email' => $settings->site_email,
                'site_phone' => $settings->site_phone,
                'site_meta_keywords' => $settings->site_meta_keywords,
                'site_meta_description' => $settings->site_meta_description,
            ]);
        }
        if ($socialLinks) {
            $this->fill([
                'facebook_url' => $socialLinks->facebook_url,
                'instagram_url' => $socialLinks->instagram_url,
                'linkdin_url' => $socialLinks->linkdin_url,
                'twitter_url' => $socialLinks->twitter_url
            ]);
        }
    }

    /**
     * Update site information
     */
    public function updateSiteInfo()
    {
        $validated = $this->validate([
            'site_title' => 'required|max:128',
            'site_email' => 'required|email',
            'site_phone' => 'numeric',
            'site_meta_keywords' => 'nullable|max:255',
            'site_meta_description' => 'nullable'
        ]);

        try {
            $settings = AboutUs::firstOrNew([]);
            $settings->fill($validated);
            $success = $settings->save();

            if ($success) {
                $this->dispatch('showToastr', [
                    'type' => 'info',
                    'message' => 'General settings updated successfully.'
                ]);
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
     * Update site about us
     */
    public function updateSiteSocialLinks()
    {
        $validated = $this->validate([
            'content' => 'required',
            'image' => 'required|url',
            'meta_keywords' => 'required|max:255',
            'meta_descriptions' => 'required',
        ]);

        try {
            $aboutUs = AboutUs::first();
            AboutUs::updateOrCreate(
                ['id' => $aboutUs?->id], // Safe access in case null
                $validated
            );
            Cache::forget(CacheKeys::ABOUT_US);

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Site social links updated successfully.'
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }
    public function render()
    {
        return view('livewire.admin.about-us');
    }
}
