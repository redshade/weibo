<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{

    /**
     * @return string
     */
    public function home() {
        return view('static_pages/home');
    }

    /**
     * @return string
     */
    public function help() {
        return view('static_pages/help');
    }

    /**
     * @return string
     */
    public function about() {
        return view('static_pages/about');
    }
}
