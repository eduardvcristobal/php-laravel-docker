<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreQuestionsRequest;
use App\Http\Requests\UpdateQuestionsRequest;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Questions::all();
        return response()->json(['data' => $questions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuestionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StoreQuestionsRequest $request)
    // {
    //     // Get the authenticated user
    //     $user = Auth::user();

    //     $question = $user->questions()->create($request->all());
    //     return response()->json($question, 201);
    // }

    public function store(Request $request)
    {

        // Validate the incoming request data
        $request->validate([
            'survey_id' => 'required|exists:surveys,id',
            'question' => 'required|string',
            'question_type' => 'required',
            'order_num' => 'required|integer',
            // 'multiple_choice_options' => 'array',
            // 'multiple_choice_options.*.id' => 'integer',
            // Add any other validation rules as needed
            'multiple_choice_options' => 'required_if:question_type,multiple_choice|array',
            'multiple_choice_options.*.id' => 'required_if:question_type,multiple_choice|integer',
        ]);

        // Create the multiple-choice question
        $data = $request->only([
            'survey_id',
            'question',
            'question_type',
            'order_num',
            'multiple_choice_options',
        ]);

        $user = auth()->user();
        $question = Questions::createMultipleChoiceQuestion($data, $user->id);

        // Optionally, you can return a response or redirect as needed
        return response()->json(['message' => 'Question created successfully', 'question' => $question], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Questions::find($id);

        if (!$question) {
            return response()->json(['error' => 'Option not found'], 404);
        }
        return response()->json($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function edit(Questions $questions, $id)
    {
        $question = Questions::find($id);
        return response()->json($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionsRequest  $request
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionsRequest $request, $id)
    {
        $question = Questions::find($id);
        return response()->json($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $option = Questions::find($id);

        if (!$option) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $option->delete();

        return response()->json(['message' => 'Question deleted successfully', 'option' => $option]);
    }
}
