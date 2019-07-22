<?php

namespace App\Http\Controllers\Controller;

use Validator;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Models\Advertiser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertiserController extends Controller
{
    public function index()
    {
        $advertisers = Advertiser::all();
        return view('pages.advertisers', compact(['advertisers']));
    }

    function create()
    {
        return view('crud.advertiser.index');
    }

    function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'url' => 'required',
            'status' => 'required',
            'image' => 'required',
        ];

        $credentials = $request->only(
            'title',
            'url',
            'status',
            'image'
        );

        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return $this->sendErrorMain('Incorrect Data', $validator->errors()->all(), 400);
        }



        $advertiser = new Advertiser();
        $advertiser->title = $request->title;
        $advertiser->url = $request->url;
        $advertiser->status = $request->status;
        $advertiser->created_by = $request->user()->id;


        if ($request->hasfile('image')) {

            $files = $request->file('image');

            $now = Carbon::now()->timestamp;


            $i  = 0;
            $file = $files;
            $nameImg = 'demo_img_' . $advertiser->id . '_' . $now . $i . '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/media/advertiser/img/';


            $file->move($path, $nameImg);

            $thumbnail = Image::make($path . $nameImg)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            // dd($path);
            $nameThumb = 'advertiser_img_' . $advertiser->id . '_' . $now . $i . '_thumb' . '.' . $file->getClientOriginalExtension();
            $thumbnail->save($path . $nameThumb);

            $advertiser->image = '/media/advertiser/img/' . $nameImg;
            $advertiser->thumbnail = '/media/advertiser/img/' . $nameThumb;
        }


        $advertiser->save();

        //return $this->sendResponseMain($question);
        return redirect()->route('advertisers');
    }

    public function edit(Advertiser $advertiser)
    {
        return view('crud.advertiser.edit', ['advertiser' => $advertiser]);
    }

    function update(Advertiser $advertiser)
    {
        $rules = [
            'question' => 'required',
            'status' => 'required',
            'options' => 'required',
        ];
        $validator = request()->validate($rules);
        $advertiser->update($validator);
        return redirect()->route('advertisers');
    }

    function active(Advertiser $advertiser)
    {
        $advertiser->delete();
        return redirect()->back();
    }
}
