<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Answer;
use App\Models\Status;
use App\Models\Demolition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DemolitionType;
use App\Models\Image as ImageModel;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Api\BaseController;
use Validator;

class DemolitionController extends BaseController
{
    private $DemolitionController;

    public function __construct()
    {
        $this->DemolitionController = app('App\Http\Controllers\Controller\DemolitionsController');
    }


    public function demolitionDescription(Request $request, $id)
    {

        if (!$id) {
            return $this->sendError('Incorrect Data', 'The id is need', 400);
        }

        $demolition = Demolition::where('id', $request->id)
            ->with('types')
            ->with('images')
            ->with('answers')
            ->with('payments')
            ->first();

        if ($demolition != null) {
            return $this->sendResponse($demolition);
        } else {
            return $this->sendError('Demolitions dont found', null, 404);
        }
    }


    public function index(Request $request)
    {
        $status = Status::where('name', $request->state)->first();
        // dd($status->id);

        if ($status != null) {
            // dd($request->user()->id);
            $demolitions = Demolition::filter(
                $request->user()->id,
                $status->id
            )
                ->with('types')
                ->with('images')
                ->with('answers')
                ->with('status')
                ->get();


            if (count($demolitions) != 0) {
                return $this->sendResponse($demolitions->toArray());
            } else {

                return $this->sendError('Demolitions dont found', null, 404);
            }
        } else {
            return $this->sendError('Status dont found', null, 400);
        }
    }

    /**
     * States Of Demolition
     * @return Response
     */


    public function waitForVisitDemolition(Request $request)
    {
        $lastState = [
            'state' => 1,
            'message' => 'request',
            'newState' => 2
        ];
        return self::baseStateDemolotion($request, $lastState);
    }


    public function quoteDemolition(Request $request)
    {
        $lastState = [
            'state' => 2,
            'message' => 'visit',
            'newState' => 3
        ];
        return self::baseStateDemolotion($request, $lastState);
    }

    public function scheduleDemolition(Request $request)
    {

        $lastState = [
            'state' => 3,
            'message' => 'quoted',
            'newState' => 4
        ];
        return self::baseStateDemolotion($request, $lastState);
    }

    public function attendedDemolition(Request $request)
    {

        $lastState = [
            'state' => 4,
            'message' => 'scheduled',
            'newState' => 5
        ];
        return self::baseStateDemolotion($request, $lastState);
    }

    public function paidOutDemolition(Request $request)
    {

        $lastState = [
            'state' => 5,
            'message' => 'attended',
            'newState' => 6
        ];
        return self::baseStateDemolotion($request, $lastState);
    }

    public function cancelDemolition(Request $request)
    {
        // Overwrite
        $lastState = [
            'newState' => 7
        ];
        return self::baseStateDemolotion($request, $lastState);
    }


    public function baseStateDemolotion(Request $request, $lastState)
    {

        $demolition = Demolition::where('id', $request->demolition_id)
            ->with('answers')
            ->with('images')
            ->first();

        if ($demolition != null) {
            if (isset($lastState['state'])) {
                if ($demolition->status_id !== $lastState['state']) {
                    return $this->sendError('Demolition must be waiting for ' . $lastState['message'], null, 403);
                }
            }

            if ($demolition->user_id == $request->user()->id) {

                $demolition = $this->DemolitionController->change_status($request->demolition_id, $lastState['newState']);

                return $this->sendResponse($demolition->toArray());
            } else {
                return $this->sendError('Unathorized user', null, 403);
            }
        } else {
            return $this->sendError('Demolitions dont fount', null, 404);
        }
    }



    public function store(Request $request)
    {


        /**
         * Data:
         * 
         * address:Calle falsa 123
         * description:To Do
         * phoneUser:3211231234
         * comment:To Remove
         * schedule:28-01-2015
         * status_id:1
         * subtotal:50
         * deposit_percentage:15
         * payment:100
         * deposit:51
         * answers[0]:1,Tres Tristes Tigres
         * types[0]:Request
         */

        $rules = [
            'address' => 'required',
            'description' => 'required',
            'phoneUser' => 'required',
            'comment' => 'required',
            'schedule' => 'required',
            'phoneUser' => 'required|numeric'
        ];

        $credentials = $request->only(

            'address',
            'description',
            'phoneUser',
            'comment',
            'schedule'
        );

        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return $this->sendError('Incorrect Data', $validator->errors(), 400);
        }


        $demolition = new Demolition();

        // $demolition->code      = $request->code;
        // $demolition->type     = $request->type;
        $demolition->address = $request->address;
        $demolition->description = $request->description; //bcrypt($request->password);
        $demolition->phoneUser = $request->phoneUser;
        $demolition->comment = $request->comment;
        // Payment
        $demolition->subtotal = $request->subtotal;
        $demolition->deposit_percentage = $request->deposit_percentage;
        $demolition->payment = $request->payment;
        $demolition->deposit = $request->deposit;
        // Date
        $demolition->schedule = Carbon::createFromFormat('d-m-Y', $request->schedule);
        // Foring
        $demolition->user_id = $request->user()->id;
        $demolition->status_id = $request->status_id;

        $demolition->save();

        //answers

        // dd();
        // $id_questions[] = $request->id_question
        if (isset($request->types) && count($request->types) != 0) {
            for ($i = 0; $i < count($request->types); $i++) {
                $demType = new DemolitionType();
                $demType->name = $request->types[$i];
                $demType->demolition_id = $demolition->id;
                $demType->save();
            }
        }


        if (isset($request->answers) && count($request->answers) != 0) {

            // dd($request->answers);

            foreach ($request->answers as $answer) {


                $separator = explode(',', $answer, 2);
                $idQuestion = $separator[0];
                $respuesta = $separator[1];


                $answer = new Answer();

                $answer->answer = $respuesta;
                $answer->question_id = $idQuestion;
                $answer->demolition_id = $demolition->id;
                $answer->save();
            }
        }


        if ($request->file('images')) {

            $files = $request->file('images');

            if (count($files) <= 5) {
                for ($i = 0; $i < count($files); $i++) {
                    $now = Carbon::now()->timestamp;


                    $file = $files[$i];
                    $nameImg = 'demo_img_' . $demolition->id . '_' . $now . $i . '.' . $file->getClientOriginalExtension();
                    $path = public_path() . '/media/demolitions/img/';


                    $file->move($path, $nameImg);

                    $thumbnail = Image::make($path . $nameImg)->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    // dd($path);
                    $nameThumb = 'demolition_img_' . $demolition->id . '_' . $now . $i . '_thumb' . '.' . $file->getClientOriginalExtension();
                    $thumbnail->save($path . $nameThumb);

                    $image = new ImageModel();
                    $image->photo = '/media/demolitions/img/' . $nameImg;
                    $image->thumbnail = '/media/demolitions/img/' . $nameThumb;
                    $image->demolition_id = $demolition->id;
                    $image->save();
                };
            }
        }

        return $this->sendResponse(Demolition::IdDemolition(
            $demolition->id
        )
            ->with('images')
            ->with('answers')
            ->with('types')
            ->orderBy('created_at', 'DESC')
            ->get());
        // return $this->sendResponse($demolition->with('answers'));

    }


    public function show($id)
    {
        $demolition = Demolition::find($id);

        if (is_null($demolition)) {
            return $this->sendError('Demolition not found.');
        }


        return $this->sendResponse($demolition->toArray(), 'Demolition retrieved successfully.');
    }
}
