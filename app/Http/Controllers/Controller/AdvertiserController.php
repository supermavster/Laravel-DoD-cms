<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;


class AdvertiserController extends Controller
{
    public function index()
    {
        $advertisers = Advertiser::all();
        return view('pages.advertisers', compact(['advertisers']));
    }
}
