<?php

namespace App\Livewire\Admin;

use App\Models\GeneralSetting;
use Exception;
use Livewire\Component;

class Settings extends Component
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
        $this->loadGeneralSettings();
    }

    /**
     * Load general settings from database
     */
    protected function loadGeneralSettings(): void
    {
        $settings = GeneralSetting::first(); // first() is more semantic than take(1)->first()
        
        if ($settings) {
            $this->fill([
                'site_title' => $settings->site_title,
                'site_email' => $settings->site_email,
                'site_phone' => $settings->site_phone,
                'site_meta_keywords' => $settings->site_meta_keywords,
                'site_meta_description' => $settings->site_meta_description,
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
            'site_meta_keywords' => 'nullable',
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

    public function render()
    {
        return view('livewire.admin.settings');
    }
}