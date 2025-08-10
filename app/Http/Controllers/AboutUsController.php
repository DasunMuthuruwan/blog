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
        $siteName = config('app.name');
        $title = "About Us | {$siteName}";
        $description = $aboutUs->meta_descriptions;
        $keywords = $aboutUs->meta_keywords;

        /** SEO Meta Tags */
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOMeta::setKeywords($keywords);
        SEOTools::setCanonical(url()->current());

        /** OpenGraph Tags */
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'article');
        SEOTools::opengraph()->setTitle($title);
        SEOTools::opengraph()->setDescription($description);

        /** Twitter Cards */
        SEOTools::twitter()->setSite('@devTalk');
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
