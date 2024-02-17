<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Responses extends Model
{
    use HasFactory;

    protected $table = 'responses';

    protected $fillable = [
        'survey_id',
        'question_id',
        'option_id',
        'rating_value',
        'response_text',
        'question_type',
        'voucher',
        'user_id',
    ];

    // Specify the fields to be hidden
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the survey that owns the response.
     * Many-to-One: A response belongs to a single survey.
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * Get the question that owns the response.
     * Many-to-One: A response belongs to a single question.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the option that owns the response.
     * Many-to-One: A response belongs to a single option.
     */
    public function option()
    {
        return $this->belongsTo(Options::class);
    }


    // public function survey()
    // {
    //     return $this->belongsTo(Survey::class);
    // }

    // //many to many relationship with options
    public function selectedOptions()
    {
        // return $this->belongsToMany(Options::class, 'response_options')->withTimestamps();
        return $this->belongsToMany(Options::class, 'response_options', 'response_id', 'option_id');
    }

    // // foreign to one Question 
    // public function question()
    // {
    //     return $this->belongsTo(Questions::class, 'question_id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
