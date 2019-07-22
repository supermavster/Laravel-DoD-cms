<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Validator;

class QuestionController extends Controller
{
    function index()
    {
        $questions = Question::all();
        return view('pages.questions', compact(['questions']));
    }

    function create()
    {
        return view('question.index');
    }

    function store(Request $request)
    {
        $rules = [
            'question' => 'required',
            'status' => 'required',
            'options' => 'required',
        ];

        $credentials = $request->only(
            'question',
            'status',
            'options'
        );

        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return $this->sendErrorMain('Incorrect Data', $validator->errors()->all(), 400);
        }

        $question = Question::create([
            "question" => $request->question,
            "status" => $request->status
        ]);

        //return $this->sendResponseMain($question);
        return redirect()->route('questions');
    }

    public function edit(Question $question)
    {
        return view('question.edit', ['question' => $question]);
    }

    function update(Question $question)
    {
        $rules = [
            'question' => 'required',
            'status' => 'required',
            'options' => 'required',
        ];
        $validator = request()->validate($rules);
        $question->update($validator);
        return redirect()->route('questions');
    }

    function active(Question $question)
    {
        $question->delete();
        //return redirect()->route('questions');
        return redirect()->back();
    }
}
