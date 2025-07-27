<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Profile\ProfilePictureUpdateRequest;
use App\Http\Requests\SiteSetting\FaviconUpdateRequest;
use App\Http\Requests\SiteSetting\LogoUpdateRequest;
use App\Models\GeneralSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use SawaStacks\Utils\Kropify;

class AdminController extends Controller
{
    private $serverError;

    public function __construct()
    {
        $this->serverError = config('exception-errors.errors.server-error');
    }

    public function adminDashboard()
    {

        return view('back.pages.dashboard', [
            'pageTitle' => 'Dashboard'
        ]);
    }

    public function logoutHandler(Request $request)
    {
        try {
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();
            if (!empty($request->source)) {
                return redirect()->back();
            }

            return redirect()->route('admin.login')->with('fail', 'You are now logged out.');
        } catch (Exception $exception) {
            return redirect()->route('admin.dashboard')->with('fail', $this->serverError);
        }
    }

    public function profileView(Request $request)
    {
        return view('back.pages.profile', [
            'pageTitle' => 'Profile'
        ]);
    }

    public function updateProfilePicture(ProfilePictureUpdateRequest $profilePictureUpdateRequest)
    {
        try {
            $user = Auth::user();
            $path = "images/users";
            $file = $profilePictureUpdateRequest->file('profile_picture_file');
            $oldPicture = $user->picture;
            $filename = 'IMG_' . uniqid() . '.png';

            $upload = Kropify::getFile($file, $filename)
                ->setDisk('public')
                ->setPath($path)
                ->save();

            if ($upload) {
                $oldFilePath = public_path("storage/{$path}/{$oldPicture}");
                if ($oldPicture != null && File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }

                // update profile picture
                $user->update([
                    'picture' => $filename
                ]);

                return ApiResponse::success([], 'Your profile picture has been updated successfully.');
            }

            return ApiResponse::success([], 'Something went wrong.');
        } catch (Exception $exception) {
            return ApiResponse::success([], $this->serverError);
        }
    }

    public function generalSettings()
    {
        return view('back.pages.general_settings', [
            'pageTitle' => 'General Settings'
        ]);
    }

    public function updateLogo(LogoUpdateRequest $logoUpdateRequest)
    {
        try {
            $settings = GeneralSetting::first();

            if ($settings) {
                $path = "images/site";
                $oldLogo = $settings->site_logo;
                $file = $logoUpdateRequest->file('site_logo');
                $filename = 'logo' . uniqid() . '.png';

                if ($logoUpdateRequest->hasFile('site_logo')) {
                    $upload = $file->move(public_path('storage/images/site'), $filename);
                    if ($upload) {
                        $oldFilePath = public_path("storage/{$path}/$oldLogo");
                        if (File::exists($oldFilePath)) {
                            File::delete($oldFilePath);
                        }

                        $settings->update([
                            'site_logo' => $filename
                        ]);

                        return ApiResponse::success(['image_path' => "storage/{$path}/{$filename}"], "Site logo has benn updated successfully.");
                    } else {
                        return ApiResponse::error('Something went to wrong in uploading new logo');
                    }
                }
            } else {
                return ApiResponse::error('Make sure you update general settings form first.');
            }
        } catch (Exception $exception) {
            return ApiResponse::success([], $this->serverError);
        }
    }

    public function updateFavicon(FaviconUpdateRequest $faviconUpdateRequest)
    {
        try {
            $settings = GeneralSetting::first();

            if ($settings) {
                $path = "images/site";
                $oldFavicon = $settings->site_favicon;
                $file = $faviconUpdateRequest->file('site_favicon');
                $filename = 'favicon' . uniqid() . '.png';

                if ($faviconUpdateRequest->hasFile('site_favicon')) {
                    $upload = $file->move(public_path('storage/images/site'), $filename);
                    if ($upload) {
                        $oldFilePath = public_path("storage/{$path}/$oldFavicon");
                        if (File::exists($oldFilePath)) {
                            File::delete($oldFilePath);
                        }

                        $settings->update([
                            'site_favicon' => $filename
                        ]);

                        return ApiResponse::success(['image_path' => "storage/{$path}/{$filename}"], "Site favicon has benn updated successfully.");
                    } else {
                        return ApiResponse::error('Something went to wrong in uploading new favicon');
                    }
                }
            } else {
                return ApiResponse::error('Make sure you update general settings form first.');
            }
        } catch (Exception $exception) {
            return ApiResponse::success([], $this->serverError);
        }
    }

    public function categoryPage()
    {
        return view('back.pages.categories.index', [
            'pageTitle' => 'Categories'
        ]);
    }

    public function manageSlider(Request $request)
    {
        return view('back.pages.silder', [
            'pageTitle' => 'Manage Home Slider'
        ]);
    }
}
