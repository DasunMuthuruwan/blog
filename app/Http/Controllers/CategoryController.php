<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return view('back.pages.categories.index', [
            'pageTitle' => 'Categories'
        ]);
    }
}
