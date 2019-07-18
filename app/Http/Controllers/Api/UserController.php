<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Mail;
use Validator;

// use Illuminate\Support\Facades\Auth;


class UserController extends BaseController
{
    public function profile(Request $request)
    {
        return response()->json([
            'image' => ($request->user()->image) ? $request->user()->image : 'none',
            'thumbnail' => ($request->user()->thumbnail) ? $request->user()->thumbnail : 'none',
            'name' => $request->user()->name,
            'name_company' => $request->user()->companyName,
            'address_company' => $request->user()->companyAddress,
            'phone' => $request->user()->phone,
            'email' => $request->user()->email
        ], 200);

    }


    public function changePassword(Request $request)
    {
        if (Hash::check($request->password, $request->user()->password)) {
            $user = User::find($request->user()->id);
            $user->password = bcrypt($request->newPassword);
            $user->save();

            $request->user()->password = $user->password;
            return $this->sendResponse($user->toArray());

        } else {
            return $this->sendError("Passwords aren't equals", null, 403);
        }


    }

    public function verify($code)
    {
        $user = User::where('confirmation_code', $code)->first();

        if (!$user) {
            return $this->sendError("email Invalid", null, 403);
        }

        $user->confirmed = true;
        $user->confirmation_code = null;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'email confirmed'
        ], 200);
    }


    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users.email',
            'phone' => 'required',
            'companyName' => 'required',
            'password' => 'required',
            'companyAddress' => 'required'
        ];

        $credentials = $request->only(
            'name',
            'email',
            'phone',
            'companyName',
            'companyAddress',
            'password'
        );


        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return $this->sendError('Incorrect Data', $validator->errors(), 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;//bcrypt($request->password);
        $user->companyName = $request->companyName;
        $user->companyAddress = $request->companyAddress;
        $user->status = 'active';
        $user->password = bcrypt($request->password);
        $user->confirmation_code = str_random(25);

        if ($request->file('image')) {

            $file = $request->file('image');

            $now = Carbon::now()->timestamp;

            $nameImg = 'user_img_' . '_' . $now . '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/media/user/img/';


            $file->move($path, $nameImg);

            $thumbnail = Image::make($path . $nameImg)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            // dd($path);
            $nameThumb = 'user_img_' . '_' . $now . '_thumb' . '.' . $file->getClientOriginalExtension();


            $thumbnail->save($path . $nameThumb);

            $user->image = 'demo_on_demand/public/media/user/img/' . $nameImg;
            $user->thumbnail = 'demo_on_demand/public/media/user/img/' . $nameThumb;
            $user->rol_id = 2;

        }

        $user->save();
        /*Mail::send('emails.confirmation_code', $user->toArray(), function ($message) use ($user) {
            $message->to($user->email, $user->name)->subject('Por favor confirma tu correo');
        });*/


        $success['message'] = "we send a link with your email confirmation";
        $success['name'] = $user->name;
        $success['email'] = $user->email;
        $success['image'] = $user->image;
        $success['thumbnail'] = $user->thumbnail;
        $success['token'] = $user->createToken('MyApp')->accessToken;


        return $this->sendResponse($success);
    }


    public function login(Request $request)
    {

        $userFind = User::where('email', $request->email)->first();

        if (Auth::attempt($request->only('email', 'password'))) {

            if ($userFind->confirmed == 1) {

                $user = Auth::user();
                $token = $user->createToken('MyApp')->accessToken;
                return response()->json([

                    'image' => $user->image,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'nameCompany' => $user->companyName,
                    'addressCompany' => $user->companyAddress,
                    'token' => $token

                ], 200);

            } else {
                return response()->json([
                    'error' => 'You address email not is confirmed'
                ], 403);
            }


        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }


        // dd($request->email);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'status' => 'loguot'

        ], 403);

    }


    public function update(Request $request)
    {
        $user = User::find($request->user()->id);

        if ($user != null) {
            // $user->image = $request->image
            $user->name = $request->name;
            $user->companyName = $request->nameCompany;
            $user->companyAddress = $request->addressCompany;
            $user->phone = $request->phone;
            $user->email = $request->email;

            if ($request->file('image')) {

                $file = $request->file('image');

                $now = Carbon::now()->timestamp;

                $nameImg = 'user_img_' . '_' . $now . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/media/user/img/';


                $file->move($path, $nameImg);

                $thumbnail = Image::make($path . $nameImg)->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                // dd($path);
                $nameThumb = 'user_img_' . '_' . $now . '_thumb' . '.' . $file->getClientOriginalExtension();


                $thumbnail->save($path . $nameThumb);

                $user->image = 'demo_on_demand/public/media/user/img/' . $nameImg;
                $user->thumbnail = 'demo_on_demand/public/media/user/img/' . $nameThumb;


                // $user->save();
            }


            $user->save();

            // $request->user()->image = $request->image
            $request->user()->name = $request->name;
            $request->user()->companyName = $request->nameCompany;
            $request->user()->companyAddress = $request->addressCompany;
            $request->user()->phone = $request->phone;
            $request->user()->email = $request->email;
            $request->user()->image = $user->image;
            $request->user()->thumbnail = $user->thumbnail;

            return $this->sendResponse($user->toArray());
        } else {

            return $this->sendError('Unauthorized user', null, 403);
        }

    }
}
