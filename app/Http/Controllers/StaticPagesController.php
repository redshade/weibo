<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StaticPagesController extends Controller
{

    /**
     * @return string
     */
    public function home() {
        $feed_items = [];
        if(Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(20);
        }

        return view('static_pages.home', compact('feed_items'));
    }

    /**
     * @return string
     */
    public function help() {
        return view('static_pages.help');
    }

    /**
     * @return string
     */
    public function about() {
        return view('static_pages.about');
    }
}
