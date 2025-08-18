<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class TermConditionsController extends Controller
{
    public function index()
    {
        /** Define SEO data */
        $siteName = config('app.name');
        $title = "Terms & Conditions | {$siteName}";
        $description = "Read the terms and conditions of using {$siteName}, including user responsibilities, rights, and legal disclaimers.";
        $keywords = ['terms and conditions', 'terms of service', 'user agreement', 'legal disclaimer'];

        /** Meta SEO */
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOMeta::setKeywords($keywords);
        SEOTools::setCanonical(url()->current());

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'article');
        SEOTools::opengraph()->setTitle($title);
        SEOTools::opengraph()->setDescription($description);

        SEOTools::twitter()->setSite('@devtalk94');
        SEOTools::jsonLd()->setTitle($title);
        SEOTools::jsonLd()->setDescription($description);

        return view('front.pages.term-conditions', [
            'pageTitle' => 'Terms & Conditions'
        ]);
    }
}
