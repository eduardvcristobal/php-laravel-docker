<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'surveys';
    protected $fillable = ['title', 'description'];

    //hidden fields
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


    /**
     * Get the responses associated with the survey.
     * One-to-Many: A survey can have multiple responses.
     */
    public function responses()
    {
        return $this->hasMany(Responses::class);
    }

    /**
     * Get the questions associated with the survey.
     * One-to-Many: A survey can have multiple questions.
     */
    public function questions()
    {
        return $this->hasMany(Questions::class);
    }
}
