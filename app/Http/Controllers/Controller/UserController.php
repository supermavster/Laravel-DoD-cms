<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\User as UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = UserModel::all();
        return view('pages.users', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = UserModel::find($id);
        if ($user != null) {
            // dd($user);
            return view('user.edit', compact('user'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->file('image'));
        $user = UserModel::find($request->id);
        if ($user != null) {
            $user->name = $request->has('name') ? $request->name : $user->name;
            $user->email = $request->has('email') ? $request->email : $user->email;
            $user->phone = $request->has('phone') ? $request->phone : $user->phone;
            $user->status = $request->has('status') ? $request->status : $user->status;
            $user->companyAddress = $request->has('addressCompany') ? $request->addressCompany : $user->companyAddress;

// dd($request);

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

                $user->image = $request->has('image') ? '/media/user/img/' . $nameImg : $user->image;

                $user->thumbnail = '/media/user/img/' . $nameThumb;
            }


            $user->save();
            return redirect()->route('users');
        } else {
            // return redirect()->route('users');
        }

        // dd($request);
    }
}
