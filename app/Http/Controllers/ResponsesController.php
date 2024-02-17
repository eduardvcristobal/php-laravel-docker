<?php

namespace App\Http\Controllers;

use App\Models\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreResponsesRequest;
use App\Http\Requests\UpdateResponsesRequest;

class ResponsesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $responses = Responses::all();
        $responses = Responses::with('options')->get();
        return response()->json(['data' => $responses]);
    }

    public function getOptionsByResponseId($responseId)
    {
        // Retrieve the response with its associated options
        $response = Responses::find($responseId);

        if (!$response) {
            return response()->json(['error' => 'Response not found'], 404);
        }

        // Retrieve the options related to the response
        $options = $response->options;

        return response()->json($options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreResponsesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResponsesRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'survey_id' => 'required|exists:surveys,id',
        //     'question_id' => 'required|exists:questions,id',
        //     'question_type' => 'required|in:yes_no,open_ended,rating,multiple_choice',
        //     'response_text' => 'required_if:question_type,open_ended|string',
        //     'rating_value' => 'required_if:question_type,rating|integer|min:1|max:5',
        //     'option_id' => 'required_if:question_type,yes_no|exists:options,id',
        //     'options' => 'required_if:question_type,multiple_choice|array',
        //     'voucher' => 'string|unique:responses,voucher',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 400);
        // }

        $responseData = [
            'survey_id' => $request->input('survey_id'),
            'question_id' => $request->input('question_id'),
            'question_type' => $request->input('question_type'),
            'response_text' => $request->input('response_text'),
            'rating_value' => $request->input('rating_value'),
            'option_id' => $request->input('option_id'),
            'voucher' => $request->input('voucher'),
            // other fields
        ];

        $response = Responses::create($responseData);

        if ($request->input('question_type') === 'multiple_choice') {
            // Attach selected options to the response for multiple-choice questions
            $response->selectedOptions()->attach($request->input('options'));
        }

        return response()->json(['response' => $response], 201);
    }

    public function storeBatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'voucher' => 'required|string',
            'responses' => 'required|array',
            'responses.*.survey_id' => 'required|exists:surveys,id',
            'responses.*.question_id' => 'required|exists:questions,id',
            'responses.*.question_type' => 'required|in:yes_no,open_ended,rating,multiple_choice',
            'responses.*.response_text' => 'required_if:responses.*.question_type,open_ended|string',
            'responses.*.rating_value' => 'required_if:responses.*.question_type,rating|integer|min:1|max:5',
            'responses.*.option_id' => 'required_if:responses.*.question_type,yes_no|exists:options,id',
            'responses.*.options' => 'required_if:responses.*.question_type,multiple_choice|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $responses = [];

        foreach ($request->input('responses') as $responseData) {
            $response = Responses::create([
                'survey_id' => $responseData['survey_id'],
                'question_id' => $responseData['question_id'],
                'question_type' => $responseData['question_type'],
                'response_text' => $responseData['response_text'] ?? '',
                'rating_value' => $responseData['rating_value'] ?? null,
                'option_id' => $responseData['option_id'] ?? null,
                'voucher' => $request->input('voucher'), // Use the common voucher for each response
                // other fields
            ]);

            if ($responseData['question_type'] === 'multiple_choice') {
                // Attach selected options to the response for multiple-choice questions
                $response->selectedOptions()->attach($responseData['options']);
            }

            $responses[] = $response;
        }

        return response()->json(['responses' => $responses], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Responses  $responses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Responses::find($id);

        if (!$response) {
            return response()->json(['error' => 'Response not found'], 404);
        }

        return response()->json(['response' => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Responses  $responses
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = Responses::find($id);
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResponsesRequest  $request
     * @param  \App\Models\Responses  $responses
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResponsesRequest $request, $id)
    {
        $response = Responses::find($id);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Responses  $responses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $responses = Responses::find($id);

        if (!$responses) {
            return response()->json(['error' => 'Responses not found'], 404);
        }

        $responses->delete();

        return response()->json(['message' => 'Responses deleted successfully', 'responses' => $responses]);
    }
}
