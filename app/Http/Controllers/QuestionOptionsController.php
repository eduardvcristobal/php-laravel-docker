<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionOptionsRequest;
use App\Http\Requests\UpdateQuestionOptionsRequest;
use App\Models\QuestionOptions;

class QuestionOptionsController extends Controller
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
     * @param  \App\Http\Requests\StoreQuestionOptionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionOptionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionOptions  $questionOptions
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionOptions $questionOptions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionOptions  $questionOptions
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionOptions $questionOptions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionOptionsRequest  $request
     * @param  \App\Models\QuestionOptions  $questionOptions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionOptionsRequest $request, QuestionOptions $questionOptions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionOptions  $questionOptions
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionOptions $questionOptions)
    {
        //
    }
}
