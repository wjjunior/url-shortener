<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class UrlController extends Controller
{
    /**
     * Returns a view to redirect the user to the right shortlink URL
     *
     * @param  String  $shortlink
     * @return mixed
     */
    public function redirectUrl(String $shortlink): View
    {
        $url = Url::where("shortlink", "like", "%$shortlink")->first();

        if(!$url) abort(404);

        Log::info('Shortlink accessed!', ['shortlink' => $shortlink, 'ip' => Request::ip(), 'user-agent' => Request::server('HTTP_USER_AGENT')]);

        return view('redirect')->with('url', $url->link);
    }
}
