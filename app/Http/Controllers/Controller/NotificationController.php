<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {

        $notifications = Notification::all();
        return view('pages.notifications', compact(['notifications']));
    }
}
