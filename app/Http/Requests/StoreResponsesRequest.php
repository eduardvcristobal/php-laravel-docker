<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResponsesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'survey_id' => 'required|exists:surveys,id',
            'question_id' => 'required|exists:questions,id',
            'question_type' => 'required|in:yes_no,open_ended,rating,multiple_choice',
            'voucher' => 'string|unique:responses,voucher',
        ];

        if ($this->input('question_type') === 'open_ended') {
            $rules['response_text'] = 'required|string';
        } elseif ($this->input('question_type') === 'rating') {
            $rules['rating_value'] = 'required|integer|min:1|max:5';
        } elseif ($this->input('question_type') === 'yes_no') {
            $rules['option_id'] = 'required|exists:options,id';
        } elseif ($this->input('question_type') === 'multiple_choice') {
            $rules['options'] = 'required|array';
        }

        return $rules;
    }
}
