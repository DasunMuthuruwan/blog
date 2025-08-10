<?php

namespace App\Livewire\Admin;

use App\Constants\CacheKeys;
use App\Exceptions\FileUploadFailedException;
use App\Models\Slide;
use Exception;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class Slides extends Component
{
    use WithFileUploads;

    public $isUpdateSlideMode = false;
    public $slide_id, $slide_heading, $slide_link, $slide_image, $slide_status = true;
    public $selected_slide_image = null;
    protected string $serverError;
    protected string $path;

    protected $listeners = [
        'updateSlidesOrdering',
        'deleteSlideAction'
    ];

    public function __construct()
    {
        $this->path = "slides/";
        $this->serverError = config('exception-errors.errors.server-error');
    }

    public function updatedSlideImage()
    {
        if ($this->slide_image) {
            $this->selected_slide_image = $this->slide_image->temporaryUrl();
        }
    }

    public function addSlide()
    {
        $this->slide_id = null;
        $this->slide_heading = null;
        $this->slide_link = null;
        $this->slide_image = null;
        $this->slide_status = true;
        $this->selected_slide_image = null;
        $this->isUpdateSlideMode = false;
        $this->showSlideModalForm();
    }

    public function showSlideModalForm()
    {
        $this->resetErrorBag();
        $this->dispatch('showSlideModalForm');
        logger()->info('ddd');
    }

    public function hideSlideModalForm()
    {
        $this->dispatch('hideSlideModalForm');
        $this->isUpdateSlideMode = false;
        $this->slide_id = null;
        $this->slide_heading = null;
        $this->slide_link = null;
        $this->slide_image = null;
        $this->slide_status = true;
    }

    public function createSlide()
    {
        $this->validate([
            'slide_heading' => 'required|max:192|unique:slides,heading',
            'slide_link' => 'nullable|url',
            'slide_image' => 'required|mimes:png,jpg,jpeg,webp|max:2048',
            'slide_status' => 'required|boolean'
        ]);

        try {

            $file = $this->slide_image;
            $fileName = 'SLD_' . date('YmdHis', time()) . '.' . $file->getClientOriginalExtension();

            // Upload Slide image
            $upload = $file->storeAs($this->path, $fileName, 'slides_uploads');
            throw_if(!$upload, FileUploadFailedException::class, 'Something went wrong while uploading slide image.');

            // Store new category
            $slide = new Slide;
            $slide->image = $fileName;
            $slide->heading = $this->slide_heading;
            $slide->link = $this->slide_link;
            $slide->status = $this->slide_status == true ? 1 : 0;
            $slide->save();
            cache()->forget(CacheKeys::HOME_SLIDES);
            $this->hideSlideModalForm();

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'New Slide has been created successfully.'
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

    public function editSlide(int $slideId)
    {
        $slide = Slide::findOrFail($slideId);
        $this->slide_id = $slide->id;
        $this->slide_heading = $slide->heading;
        $this->slide_link = $slide->link;
        $this->slide_status = $slide->status == 1 ? true : false;
        $this->slide_image = null;
        $this->selected_slide_image = asset("images/slides/{$slide->image}");
        $this->isUpdateSlideMode = true;
        $this->showSlideModalForm();
    }

    public function updateSlide()
    {
        $this->validate([
            'slide_heading' => "required|unique:slides,heading,{$this->slide_id}",
            'slide_link' => 'nullable|url',
            'slide_image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'slide_status' => 'required|boolean'
        ]);

        try {
            $slide = Slide::findOrFail($this->slide_id);
            $slideImageName = $slide->image;

            if ($this->slide_image) {
                $file = $this->slide_image;
                $fileName = 'SLD_' . date('YmdHis', time()) . '.' . $file->getClientOriginalExtension();

                // Upload Slide image
                $upload = $file->storeAs($this->path, $fileName, 'slides_uploads');
                throw_if(!$upload, FileUploadFailedException::class, 'Something went wrong while uploading slide image.');

                $slidePath = "images/{$this->path}";
                $oldSlideImage = $slide->image;
                if (!empty($oldSlideImage) && File::exists(public_path("{$slidePath}/{$oldSlideImage}"))) {
                    File::delete(public_path("{$slidePath}/{$oldSlideImage}"));
                }
                $slideImageName = $fileName;
            }

            $this->isUpdateSlideMode = true;
            $slide->heading = $this->slide_heading;
            $slide->link = $this->slide_link;
            $slide->image = $slideImageName;
            $slide->status = $this->slide_status == true ? 1 : 0;
            $slide->save();
            cache()->forget(CacheKeys::HOME_SLIDES);

            $this->hideSlideModalForm();
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Slide has been updated successfully.'
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

    public function updateSlidesOrdering(array $positions)
    {
        try {
            foreach ($positions as $key => $position) {
                [$index, $newPosition] = $position;
                Slide::where('id', $index)->update([
                    'ordering' => $newPosition
                ]);
            }
            cache()->forget(CacheKeys::HOME_SLIDES);
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Slide ordering have been updated successfully.'
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    public function deleteSlideAction(int $id)
    {
        try {
            $slide = Slide::findOrFail($id);

            // Delete Slide imag
            $slidePath = "images/{$this->path}";
            $oldSlideImage = $slide->image;
            if (!empty($oldSlideImage) && File::exists(public_path("{$slidePath}/{$oldSlideImage}"))) {
                File::delete(public_path("{$slidePath}/{$oldSlideImage}"));
            }

            $slide->delete();
            cache()->forget(CacheKeys::HOME_SLIDES);
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Slide have been deleted successfully.'
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
        return view('livewire.admin.slides', [
            'slides' => Slide::orderBy('ordering', 'asc')->paginate(10)
        ]);
    }
}
