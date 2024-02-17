<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ResponsesController;
use App\Http\Controllers\SurveyReportController;
use App\Http\Controllers\QuestionReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//No authentication required
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protected by Passport's authentication middleware
Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', AuthController::class);
    Route::post('users/reset', [AuthController::class, 'reset']);
    Route::post('users/activate/{token}', [AuthController::class, 'activate']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('surveys', SurveyController::class);
    Route::apiResource('options', OptionController::class);
    Route::get('options/{optionId}/responses', [OptionController::class, 'getResponsesByOptionId']);

    Route::apiResource('questions', QuestionsController::class);
    Route::apiResource('responses', ResponsesController::class);
    Route::get('responses/{responseId}/options', [ResponsesController::class, 'getOptionsByResponseId']);
    Route::post('responses/batch', [ResponsesController::class, 'storeBatch']);

    Route::get('reports/survey/{survey_id}', [SurveyReportController::class, 'getOverallStatistics']);
    Route::get('reports/survey/{survey_id}/question/{question_id}', [SurveyReportController::class, 'getSurveyData']);

    Route::get('reports/question/{question_id}', [QuestionReportController::class, 'getDetailedReports']);

    // use App\Http\Controllers\ResponseController;


});
