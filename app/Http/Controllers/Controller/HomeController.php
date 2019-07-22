<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Demolition as DemolitionModel;
use App\Models\Payment;
use App\Models\User as UserModel;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $users = UserModel::orderBy('id', 'desc')->get();
        $demolitions = DemolitionModel::orderBy('id', 'desc')->with('user')->get();
        $payments = Payment::orderBy('id', 'desc')->get();

        return view('pages.home', compact('users', 'payments', 'demolitions'));
    }
}
