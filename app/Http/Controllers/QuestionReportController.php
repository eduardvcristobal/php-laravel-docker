<?php

namespace App\Http\Controllers;

use App\Models\ResponseOptions;
use App\Models\Questions;
use App\Models\Responses;
use Illuminate\Http\Request;

class QuestionReportController extends Controller
{
    public function getDetailedReports($questionId)
    {
        $question = Questions::find($questionId);
        //if $question is null, return 404
        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }
        return $question->options;
        // Get detailed reports for the question with options
        $responses = $question->options;


        // Return the response
        return response()->json([
            'question_id' => $question->id,
            'question_text' => $question->question,
            'responses' => $responses->map(function ($response) {
                return [
                    'id' => $response->id,
                    'survey_id' => $response->survey_id,
                    'question_id' => $response->question_id,
                    'option_id' => $response->option_id,
                    'options' => $response->options,
                    'response_text' => $response->response_text,
                    'voucher' => $response->voucher,
                    'user_id' => $response->user_id,
                    // 'created_at' => $response->created_at,
                    // 'updated_at' => $response->updated_at,
                    'question_type' => $response->question_type,
                    'rating_value' => $response->rating_value,
                ];
            }),
            // Add more details as needed
        ]);
    }


    public function getQuestionResponse($questionId)
    {
        $response = Responses::with('question.options')->where('question_id', $questionId)->first();

        return response()->json($response);
    }
}
