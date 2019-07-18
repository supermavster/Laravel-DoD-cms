<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Demolition as DemolitionModel;
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
        $users = UserModel::orderBy('id', 'desc')->take(7)->get();

        $demolitions = DemolitionModel::
        orderBy('id',
            'desc'
        )
            // ->with('user')
            ->take(7)
            ->get();
        // dd($demolitions);
        return view('home', compact('users', 'demolitions'));
    }
}
