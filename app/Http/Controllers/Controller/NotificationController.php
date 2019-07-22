<?php

namespace App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class NotificationController extends Controller
{
    public function index()
    {
        $users = User::all();
        $notifications = Notification::all();
        return view('pages.notifications', compact(['notifications', 'users']));
    }

    function store(Request $request)
    {
        $rules = [
            'users' => 'required',
            'description' => 'required',
        ];

        $credentials = $request->only(
            'users',
            'description'
        );

        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return $this->sendErrorMain('Incorrect Data', $validator->errors()->all(), 400);
        }

        $user = User::where('name', 'like', '%' . $request->users . '%')->first();

        $description = $request->description;
        $notification = new Notification();
        $notification->description = $description;
        $notification->user_id = $user->id;
        $notification->save();
        //return $this->sendResponseMain($question);
        return redirect()->route('notifications');
    }

    function active(Notification $notification)
    {
        $notification->delete();
        //return redirect()->route('questions');
        return redirect()->back();
    }
}
