<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionController extends Controller
{
    function index()
    {
        $questions = Question::all();
        return view('pages.questions', compact(['questions']));
    }
}
