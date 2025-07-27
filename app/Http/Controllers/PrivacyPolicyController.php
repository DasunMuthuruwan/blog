<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    
    public function index() {
        /** Meta  SEO */
        /** Define SEO data */
        $siteName = config('app.name');
        $title = "Privacy Policy | {$siteName}";
        $description = "Read our privacy policy to understand how Your {$siteName} collects, uses, and protects your data.";
        $keywords = ['privacy policy', 'data protection', 'personal information', 'user rights'];

        /** Meta SEO */
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOMeta::setKeywords($keywords);
        SEOTools::setCanonical(url()->current());

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'article');
        SEOTools::opengraph()->setTitle($title);
        SEOTools::opengraph()->setDescription($description);

        SEOTools::twitter()->setSite('@techSolve');
        SEOTools::jsonLd()->setTitle($title);
        SEOTools::jsonLd()->setDescription($description);

        return view('front.pages.privacy-policy', [
            'pageTitle' => 'Privacy Policy'
        ]);
    }
}
