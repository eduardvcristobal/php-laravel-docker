<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyReportController extends Controller
{
    public function getOverallStatistics($surveyId)
    {
        // Retrieve the survey
        $survey = Survey::findOrFail($surveyId);

        // Get overall statistics
        $totalResponses = $survey->responses()->count();
        $averageRating = $survey->responses()->avg('rating_value');

        // You can add more statistics based on your requirements

        // Return the response
        return response()->json([
            'survey_id' => $survey->id,
            'survey_title' => $survey->title,
            'total_responses' => $totalResponses,
            'average_rating' => $averageRating,
            // Add more statistics as needed
        ]);
    }

    public function getSurveyData($surveyId, $questionId)
    {
        // return $surveyId;
        $surveyData = DB::table('questions')
            ->join('responses', 'questions.id', '=', 'responses.question_id')
            ->leftJoin('response_options', 'responses.id', '=', 'response_options.response_id')
            ->leftJoin('options', 'response_options.option_id', '=', 'options.id')
            ->select(
                'questions.id as question_id',
                'questions.question as question_text',
                'responses.id as response_id',
                'responses.survey_id',
                'responses.question_id as response_question_id',
                'responses.option_id',
                'responses.response_text',
                'responses.voucher',
                'options.id as option_id',
                'options.option',
                'options.tags',
                'options.user_id'
            )
            ->where('questions.id', '=', $questionId)
            ->where('responses.survey_id', '=', $surveyId)
            ->get();


        $formattedResponse = $this->formatSurveyData($surveyData);

        return response()->json($formattedResponse);
    }

    private function formatSurveyData($data)
    {
        $formattedResponse = [];

        foreach ($data as $item) {
            $formattedResponse['question_id'] = $item->question_id;
            $formattedResponse['question_text'] = $item->question_text;

            $response = [
                'id' => $item->response_id,
                'survey_id' => $item->survey_id,
                'question_id' => $item->response_question_id,
                'option_id' => $item->option_id,
                'options' => [
                    [
                        'id' => $item->option_id,
                        'option' => $item->option,
                        'tags' => $item->tags,
                        'user_id' => $item->user_id,
                    ]
                ],
                'response_text' => $item->response_text,
                'voucher' => $item->voucher,
                'user_id' => $item->user_id,
                'question_type' => 'multiple_choice',
                'rating_value' => null,
            ];

            $formattedResponse['responses'][] = $response;
        }

        return $formattedResponse;
    }
}
