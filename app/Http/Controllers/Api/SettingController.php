<?php

namespace App\Http\Controllers\Api;

use App\Models\Advertiser;
use App\Models\Question;
use App\Models\TypesDemolition;
use Illuminate\Http\Response;

class SettingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $questions = Question::all();
        $types = TypesDemolition::all();
        $publicies = Advertiser::all('id', 'title', 'url', 'image', 'thumbnail');
        // filter(
        //     $request->user()->id
        // )
        // ->with('images')
        // ->orderBy('created_at','DESC')
        // ->get();

        if ($questions->count() == 0) {
            return response()->json([
                'status' => 'fail',
                'message' => 'questions dont fount'
            ], 404);
        }

        //$result = [];
        //$result['questions'] = $questions;

        // return response()->json($user_demolitions, 200);

        return response()->json([
            'questions' => $questions,
            'typesDemolition' => $types,
            'publicies' => $publicies
        ], 404);
        // $demolitions = Demolition::all();


    }
}
