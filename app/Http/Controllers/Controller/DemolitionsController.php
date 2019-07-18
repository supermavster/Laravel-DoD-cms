<?php

namespace App\Http\Controllers\Controller;

use App\Demolition;
use App\Http\Controllers\Controller;
use App\Models\Demolition as DemolitionModel;
use App\Models\ScheduleDate;
use App\Models\Status as StatusModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DemolitionsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Demolition $demolition
     * @return Response
     */
    public function showDemolition($id)
    {
        $demo = DemolitionModel::where('id', $id)
            ->with('answers')
            ->with('images')
            ->first();
        return $demo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Demolition $demolition
     * @return Response
     */
    public function edit(Request $request)
    {
        $demolition = DemolitionModel::find($request->id);
        $statuses = StatusModel::all();
        return view('demolition.edit', compact('demolition', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Demolition $demolition
     * @return Response
     */
    public function update(Request $request)
    {

        // dd($request->status);
        $scheduleDate = new ScheduleDate();
        $demolition = DemolitionModel::find($request->id);
        // $status = $demolition->status->where('name',$request->status)->first();

        if ($demolition != null) {


            $demolition->subtotal = $request->has('total') ? $request->total : $demolition->subtotal;

            $demolition->deposit = $request->has('deposit') ? $request->deposit : $demolition->deposit;

            $demolition->deposit_percentage = $request->has('percentage') ? $request->percentage : $demolition->deposit_percentage;

            $payment = $demolition->subtotal - $demolition->deposit;

            $demolition->payment = $payment;

            $demolition->status_id = $request->has('status') ? $request->status : $demolition->status_id;

            $arrayDates = [];

            array_push($arrayDates, $request->date1, $request->date2, $request->date3);

            foreach ($arrayDates as $date) {
                if ($request->has('date1') || $request->has('date2') || $request->has('date3')) {
                    $scheduleDate->date = Carbon::parse($date)->format('m/d/y');
                    $scheduleDate->demolition_id = $request->id;
                    $scheduleDate->save();
                }


            }

            $demolition->save();
            return redirect()->route('demolitions.index');
        } else {

        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $demolitions = DemolitionModel::all();
        return view('demolition.index', compact('demolitions'));
    }


    public function change_status($demolition_id, $status_id)
    {

        $demolition = DemolitionModel::findOrFail($demolition_id);


        $demolition->status_id = $status_id;

        $demolition->save();

    }
}
