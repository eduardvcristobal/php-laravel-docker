<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOptions extends Model
{
    use HasFactory;

    protected $table = 'question_options';

    protected $fillable = [
        'questions_id',
        'options_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the question that owns the question option.
     * Many-to-One: A question option belongs to a single question.
     */
    public function question()
    {
        return $this->belongsTo(Questions::class, 'question_id', 'id');
    }

    /**
     * Get the option that owns the question option.
     * Many-to-One: A question option belongs to a single option.
     */
    public function option()
    {
        return $this->belongsTo(Options::class, 'option_id');
    }
}
