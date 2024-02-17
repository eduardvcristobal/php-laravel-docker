<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Options extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'options';
    //fillable fields for options, option and tags
    protected $fillable = ['option', 'tags'];

    //hide created_at and updated_at fields
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function questionOptions()
    {
        return $this->hasMany(QuestionOptions::class);
    }

    //many to many relationship with Responses. Table created in response
    public function responses()
    {
        return $this->belongsToMany(Responses::class, 'response_options', 'option_id', 'response_id');
    }
}
