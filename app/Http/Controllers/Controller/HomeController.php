<?php

namespace App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        $demolitions = null;
        return view('home', compact('users', 'demolitions'));
    }
}
