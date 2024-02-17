<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;
    protected $table = 'questions';

    protected $fillable = [
        'survey_id',
        'user_id',
        'question',
        'question_type',
        'order_num',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the options associated with the question.
     * Many-to-Many: A question can have multiple options.
     */
    public function options()
    {
        return $this->belongsToMany(Options::class, 'question_options');
    }

    /**
     * Get the question options associated with the question.
     * One-to-Many: A question can have multiple question options.
     */
    public function questionOptions()
    {
        return $this->hasMany(QuestionOptions::class);
    }

    /**
     * Get the survey that owns the question.
     * Many-to-One: A question belongs to a single survey.
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function multipleChoiceOptions()
    {
        return $this->hasMany(QuestionOptions::class, 'question_id');
    }

    public static function createMultipleChoiceQuestion($data, $userId)
    {
        $question = self::create([
            'survey_id' => $data['survey_id'],
            'user_id' => $userId,
            'question' => $data['question'],
            'question_type' => $data['question_type'],
            'order_num' => $data['order_num'],
        ]);

        if ($data['question_type'] === 'multiple_choice' && isset($data['multiple_choice_options'])) {
            foreach ($data['multiple_choice_options'] as $option) {
                $question->multipleChoiceOptions()->create([
                    'option_id' => $option['id'],
                    'user_id' => $userId,
                ]);
            }
        }

        // return $question && questionOptions from the Question
        $questionOptions =  $question->load('multipleChoiceOptions');
        //map the multipleChoiceOptions and remove the 
    }

    // public function responses()
    // {
    //     return $this->hasMany(Responses::class, 'question_id');
    // }
}
