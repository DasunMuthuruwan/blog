<?php

namespace App\Livewire\Admin;

use App\Constants\CacheKeys;
use App\Exceptions\FileUploadFailedException;
use App\Models\GeneralSetting;
use App\Models\SiteSocialLink;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Settings extends Component
{
    use WithFileUploads;

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

    // About Us
    public $content, $image, $meta_keywords, $meta_descriptions, $selected_image = null;

    // site social links form properties
    public $facebook_url, $instagram_url, $linkdin_url, $twitter_url;

    protected string $serverError;

    public function __construct()
    {
        $this->serverError = config('exception-errors.errors.server-error');
    }

    public function updatedImage()
    {
        if ($this->image) {
            $this->selected_image = $this->image->temporaryUrl();
        }
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
        $settings = DB::table('general_settings')->first(); // first() is more semantic than take(1)->first()
        $socialLinks = DB::table('site_social_links')->first();
        $aboutUs = DB::table('about_us')->first();
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

        if ($aboutUs) {
            $this->fill([
                'content' => $aboutUs->content,
                'image' => $aboutUs->image,
                'meta_keywords' => $aboutUs->meta_keywords,
                'meta_descriptions' => $aboutUs->meta_descriptions
            ]);
            $this->selected_image = asset("images/aboutus/{$aboutUs->image}");
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
            $settings = GeneralSetting::firstOrNew([]);
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
     * Update site social links
     */
    public function updateSiteSocialLinks()
    {
        $validated = $this->validate([
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkdin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
        ]);

        try {
            $siteSocialLinks = SiteSocialLink::first();
            SiteSocialLink::updateOrCreate(
                ['id' => $siteSocialLinks?->id], // Safe access in case null
                $validated
            );
            Cache::forget(CacheKeys::SITE_SOCIAL_LINKS);

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Site social links updated successfully.'
            ]);
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
    public function updateSiteAboutUs()
    {
        $this->dispatch('refreshCkeditor');
        $this->validate([
            'content' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:1024',
            'meta_keywords' => 'required|max:255',
            'meta_descriptions' => 'required',
        ]);

        try {
            $aboutUs = DB::table('about_us')->first();
            throw_if(!$aboutUs, ModelNotFoundException::class, 'About us details not found.');

            $file = $this->image;
            $fileName = 'About_' . date('YmdHis', time()) . '.' . $file->getClientOriginalExtension();

            // Upload about us image
            $upload = $file->storeAs("aboutus", $fileName, 'aboutus');
            throw_if(!$upload, FileUploadFailedException::class, 'Something went wrong while uploading about us image.');
            $path = "images/aboutus";
            $oldImage = $aboutUs->image;
            if (!empty($oldImage) && File::exists(public_path("{$path}/{$oldImage}"))) {
                File::delete(public_path("{$path}/{$oldImage}"));
            }

            DB::table('about_us')->where('id', $aboutUs->id)->update([
                'content' => $this->content,
                'image' => $fileName,
                'meta_keywords' => $this->meta_keywords,
                'meta_descriptions' => $this->meta_descriptions
            ]);
            Cache::forget(CacheKeys::ABOUT_US);
            $this->image = null;

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Site about us updated successfully.'
            ]);
        } catch (ModelNotFoundException $modelNotFoundException) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $modelNotFoundException->getMessage()
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
        return view('livewire.admin.settings');
    }
}
