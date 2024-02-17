<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMultipleChoiceQuestionsRequest;
use App\Http\Requests\UpdateMultipleChoiceQuestionsRequest;
use App\Models\ResponseOptions;

class ResponseOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMultipleChoiceQuestionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMultipleChoiceQuestionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResponseOptions  $ResponseOptions
     * @return \Illuminate\Http\Response
     */
    public function show(ResponseOptions $ResponseOptions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResponseOptions  $ResponseOptions
     * @return \Illuminate\Http\Response
     */
    public function edit(ResponseOptions $ResponseOptions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMultipleChoiceQuestionsRequest  $request
     * @param  \App\Models\ResponseOptions  $ResponseOptions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMultipleChoiceQuestionsRequest $request, ResponseOptions $ResponseOptions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResponseOptions  $ResponseOptions
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResponseOptions $ResponseOptions)
    {
        //
    }
}
