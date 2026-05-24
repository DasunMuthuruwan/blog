<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::first();

        /** Site config */

        $settings = settings();
        $title = "{$settings->site_title} - About Us";
        $siteLogo = $settings->site_logo ?? '';
        $imgUrl = $siteLogo ? asset("/storage/images/site/{$siteLogo}") : "";
        $currentUrl = url()->current();
        $description = $aboutUs->meta_descriptions ?? '';
        $keywords = $aboutUs->meta_keywords ?? '';
        $imgUrl = $siteLogo ? asset("/storage/images/site/{$siteLogo}") : "";

        /** SEO Meta Tags */
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);

        SEOMeta::setKeywords($keywords);
        SEOTools::setCanonical($currentUrl);

        /** OpenGraph Tags */
        SEOTools::opengraph()->setUrl($currentUrl);
        SEOTools::opengraph()->addProperty('type', 'article');
        SEOTools::opengraph()->setTitle($title);
        SEOTools::opengraph()->setDescription($description);
        SEOTools::opengraph()->addImage($imgUrl);

        /** Twitter Cards */
        SEOTools::twitter()->setSite('@devtalk94');
        SEOTools::twitter()->addImage($imgUrl);
        SEOTools::twitter()->setTitle($title);
        SEOTools::twitter()->setDescription($description);

        /** JSON-LD Schema */
        SEOTools::jsonLd()->setTitle($title);
        SEOTools::jsonLd()->setDescription($description);

        return view('front.pages.about', [
            'pageTitle' => 'About Us',
            'about_us' => $aboutUs
        ]);
    }
}
