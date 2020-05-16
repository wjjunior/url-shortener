<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\View\View;

class UrlController extends Controller
{
    public function redirectUrl(String $shortlink): View
    {
        $url = Url::where("shortlink", "like", "%$shortlink")->first();

        if(!$url) abort(404);

        return view('redirect')->with('url', $url->link);
    }
}
