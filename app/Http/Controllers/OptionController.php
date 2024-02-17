<?php

namespace App\Http\Controllers;

use App\Models\Options;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOptionRequest;
use App\Http\Requests\UpdateOptionRequest;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Options::all();
        return response()->json(['data' => $surveys]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOptionRequest $request)
    {

        // Get the authenticated user
        $user = Auth::user();

        // Create the option
        // $option = Option::create($request->all());

        // Create the option and associate it with the authenticated user
        $option = $user->options()->create($request->all());

        // Return a JSON response
        return response()->json($option, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $option = Options::find($id);

        if (!$option) {
            return response()->json(['error' => 'Option not found'], 404);
        }

        return response()->json($option);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOptionRequest  $request
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOptionRequest $request, Options $option)
    {
        $option = Options::find($option->id);

        if (!$option) {
            return response()->json(['error' => 'Option not found'], 404);
        }

        $option->update($request->all());

        return response()->json($option);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $option = Options::find($id);

        if (!$option) {
            return response()->json(['error' => 'Option not found'], 404);
        }

        $option->delete();

        return response()->json(['message' => 'Option deleted successfully', 'option' => $option]);
    }

    public function getResponsesByOptionId($optionId)
    {

        $option = Options::find($optionId);

        if (!$option) {
            return response()->json(['error' => 'Option not found'], 404);
        }

        $responses = $option->responses;
        return response()->json($responses);
    }
}
