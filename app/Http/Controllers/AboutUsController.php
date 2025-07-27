<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        /** Site config */
        $siteName = config('app.name');
        $title = "About Us | {$siteName}";
        $description = "Discover what {$siteName} is all about — a hub for practical programming tutorials, code snippets, and developer resources.";
        $keywords = ['about us', $siteName, 'developer tutorials', 'coding tips', 'Laravel blog', 'React', 'Vue', 'Javascript'];

        /** SEO Meta Tags */
        SEOTools::setTitle($title);
        SEOTools::setDescription($description);
        SEOMeta::setKeywords($keywords);
        SEOTools::setCanonical(url()->current());

        /** OpenGraph Tags */
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'article');
        SEOTools::opengraph()->setTitle($title);
        SEOTools::opengraph()->setDescription($description);

        /** Twitter Cards */
        SEOTools::twitter()->setSite('@techSolve');
        SEOTools::twitter()->setTitle($title);
        SEOTools::twitter()->setDescription($description);

        /** JSON-LD Schema */
        SEOTools::jsonLd()->setTitle($title);
        SEOTools::jsonLd()->setDescription($description);

        return view('front.pages.about', [
            'pageTitle' => 'About Us'
        ]);
    }
}
