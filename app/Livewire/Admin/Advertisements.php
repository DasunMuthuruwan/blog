<?php

namespace App\Livewire\Admin;

use App\Constants\CacheKeys;
use App\Exceptions\FileUploadFailedException;
use App\Models\Ads;
use App\Rules\BlockDarkWebUrlsRule;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Advertisements extends Component
{
    use WithFileUploads;

    public $isUpdateAdsMode = false;
    public $ad_id, $title, $type, $content, $image, $url, $start_at, $end_at, $is_default = false;
    public $selected_image = null;
    protected string $serverError;
    protected string $path;

    protected $listeners = [
        'deleteAdvertisementAction'
    ];

    public function __construct()
    {
        $this->path = "ads/";
        $this->serverError = config('exception-errors.errors.server-error');
    }

    public function updatedImage()
    {
        if ($this->image) {
            $this->selected_image = $this->image->temporaryUrl();
        }
    }

    public function addAdvertisement()
    {
        $this->ad_id = null;
        $this->title = null;
        $this->type = null;
        $this->content = null;
        $this->image = null;
        $this->start_at = null;
        $this->end_at = null;
        $this->is_default = false;
        $this->selected_image = null;
        $this->isUpdateAdsMode = false;
        $this->showAdvertisementModalForm();
    }

    public function showAdvertisementModalForm()
    {
        $this->resetErrorBag();
        $this->dispatch('showAdvertisementModalForm');
        logger()->info('ddd');
    }

    public function hideAdvertisementModalForm()
    {
        $this->dispatch('hideAdvertisementModalForm');
        $this->isUpdateAdsMode = false;
        $this->ad_id = null;
        $this->type = null;
        $this->title = null;
        $this->content = null;
        $this->image = null;
        $this->start_at = null;
        $this->end_at = null;
        $this->url = null;
        $this->is_default = false;
    }

    public function createAdvertisement()
    {
        $this->validate([
            'title' => 'required|max:192|unique:ads,title',
            'type' => 'required|in:corner,banner,popup',
            'url' => [
                'required',
                'url',
                new BlockDarkWebUrlsRule
            ],
            "content" => [
                Rule::requiredIf(empty($this->image)),
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!empty($this->content) && !empty($this->image)) {
                        $fail('Only one of image or content can be filled, not both.');
                    }
                }
            ],
            "image" => [
                Rule::requiredIf(empty($this->content)),
                'nullable',
                'mimes:png,jpg,jpeg',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if (!empty($this->content) && !empty($this->image)) {
                        $fail('Only one of image or content can be filled, not both.');
                    }
                }
            ],
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'is_default' => 'required|boolean'
        ]);

        try {

            $file = $this->image;
            $fileName = null;
            if ($this->image) {
                $fileName = 'Ads_' . date('YmdHis', time()) . '.' . $file->getClientOriginalExtension();

                // Upload Ads image
                $upload = $file->storeAs($this->path, $fileName, 'ads');
                throw_if(!$upload, FileUploadFailedException::class, 'Something went wrong while uploading ads image.');
            }


            // Store new Ads
            $ads = new Ads;
            $ads->image = $fileName;
            $ads->title = $this->title;
            $ads->type = $this->type;
            $ads->content = $this->content;
            $ads->start_at = $this->start_at;
            $ads->end_at = "{$this->end_at} 23:59:59";
            $ads->url = $this->url;
            $ads->is_default = $this->is_default == true ? 1 : 0;
            $ads->save();
            Cache::forget(CacheKeys::CORNER_AD);
            Cache::forget(CacheKeys::POPUP_AD);

            $this->hideAdvertisementModalForm();

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'New Ads has been created successfully.'
            ]);
        } catch (FileUploadFailedException $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    #[On('updateStartAt')]
    public function handleStartAtUpdate($value)
    {
        Log::info("updateStartAt received:", ['value' => $value]);
        $this->start_at = $value['value'] ?? $value;
    }

    #[On('updateEndAt')]
    public function handleEndAtUpdate($value)
    {
        Log::info("updateEndAt received:", ['value' => $value]);
        $this->end_at = $value['value'] ?? $value;
    }

    public function editAd(int $addId)
    {   
        $ad = Ads::findOrFail($addId);
        $this->ad_id = $ad->id;
        $this->type = $ad->type;
        $this->title = $ad->title;
        $this->content = $ad->content;
        $this->url = $ad->url;
        $this->start_at = $ad->start_at;
        $this->end_at = $ad->end_at;
        $this->is_default = $ad->is_default == 1 ? true : false;
        $this->image = null;
        $this->selected_image = asset("images/ads/{$ad->image}");
        $this->isUpdateAdsMode = true;
        $this->showAdvertisementModalForm();

        $this->dispatch('setEditDates', [
            'start_at' => $this->start_at,
            'end_at' => $this->end_at
        ]);
    }

    public function updateAdvertisement()
    {
        $ad = Ads::findOrFail($this->ad_id);
        $this->validate([
            'title' => "required|max:192|unique:ads,title,{$this->ad_id}",
            'type' => 'required|in:corner,banner,popup',
            'url' => [
                'required',
                'url',
                new BlockDarkWebUrlsRule
            ],
            "content" => [
                Rule::requiredIf(empty($this->image) && empty($ad->image)),
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!empty($this->content) && !empty($this->image)) {
                        $fail('Only one of image or content can be filled, not both.');
                    }
                }
            ],
            "image" => [
                Rule::requiredIf(empty($this->content) && empty($ad->image)),
                'nullable',
                'mimes:png,jpg,jpeg',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if (!empty($this->content) && !empty($this->image)) {
                        $fail('Only one of image or content can be filled, not both.');
                    }
                }
            ],
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'is_default' => 'required|boolean'
        ]);

        try {
            $imageName = $ad->image;

            if ($this->image) {
                $file = $this->image;
                $fileName = 'Ads_' . date('YmdHis', time()) . '.' . $file->getClientOriginalExtension();

                // Upload ads image
                $upload = $file->storeAs($this->path, $fileName, 'ads');
                throw_if(!$upload, FileUploadFailedException::class, 'Something went wrong while uploading image.');

                $path = "images/{$this->path}";
                $oldImage = $ad->image;
                if (!empty($oldImage) && File::exists(public_path("{$path}/{$oldImage}"))) {
                    File::delete(public_path("{$path}/{$oldImage}"));
                }
                $imageName = $fileName;
            }
            
            $this->isUpdateAdsMode = true;
            $ad->type = $this->type;
            $ad->content = $this->content;
            $ad->title = $this->title;
            $ad->url = $this->url;
            $ad->start_at = $this->start_at;
            $ad->end_at = "{$this->end_at} 23:59:59";
            $ad->image = $imageName;
            $this->is_default = $ad->is_default == 1 ? true : false;
            $ad->save();
            Cache::forget(CacheKeys::CORNER_AD);
            Cache::forget(CacheKeys::POPUP_AD);

            $this->hideAdvertisementModalForm();
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Ads has been updated successfully.'
            ]);
        } catch (FileUploadFailedException $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    public function deleteAdvertisementAction(int $id)
    {
        try {
            $ad = Ads::findOrFail($id);

            // Delete Ad imag
            $path = "images/{$this->path}";
            $oldImage = $ad->image;
            if (!empty($oldImage) && File::exists(public_path("{$path}/{$oldImage}"))) {
                File::delete(public_path("{$path}/{$oldImage}"));
            }

            $ad->delete();
            Cache::forget(CacheKeys::CORNER_AD);
            Cache::forget(CacheKeys::POPUP_AD);
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Ad have been deleted successfully.'
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
        return view('livewire.admin.advertisements', [
            'ads' => Ads::latest()->paginate(10)
        ]);
    }
}
