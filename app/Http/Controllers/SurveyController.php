<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSurveyRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateSurveyRequest;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::all();
        return response()->json(['data' => $surveys]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSurveyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurveyRequest $request): JsonResponse
    {
        // Validation will be automatically handled by StoreSurveyRequest

        // Get the authenticated user
        $user = Auth::user();

        // Create the survey
        // $survey = Survey::create($request->all());

        // Create the survey and associate it with the authenticated user
        $survey = $user->surveys()->create($request->all());

        // Return a JSON response
        return response()->json($survey, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json(['error' => 'Survey not found'], 404);
        }

        return response()->json($survey);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSurveyRequest  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSurveyRequest $request, $id)
    {
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json(['error' => 'Survey not found'], 404);
        }

        $survey->update($request->all());

        return response()->json($survey);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json(['error' => 'Survey not found'], 404);
        }

        $survey->delete();

        return response()->json(['message' => 'Survey deleted successfully'], 204);
    }
}
