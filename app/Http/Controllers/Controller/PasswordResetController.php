<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordResetRequest;
use App\PasswordReset;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{


    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);


        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'message' => "We can't find a user with that e-mail address."
            ], 404);


        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60)
            ]
        );


        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }

    public function prueba(Request $request)
    {
        dd($request->email);
    }


    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();

        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }
        // return $passwordReset->token;
        return view('ResetPassword')
            ->with('email', $passwordReset->email)
            ->with('token', $passwordReset->token);
        // return response()->json($passwordReset);
    }


    public function reset(Request $request)
    {


        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
// dd($request->email);


        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();


        if (!$passwordReset)
            return response()->json([
                'message' => "This password reset token is invalid."
            ], 404);


        $user = User::where('email', $passwordReset->email)->first();

        if (!$user)
            return response()->json([
                'message' => "We can't find a user with that e-mail address."
            ], 404);

        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));

        return response()->json([
            'message' => "your password was reset with success ",
            'user' => $user
        ], 200);
    }


}
