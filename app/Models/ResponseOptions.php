<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseOptions extends Model
{
    use HasFactory;

    protected $table = 'response_options';

    protected $fillable = [
        'question_id',
        'option_id',
        'user_id',
    ];

    public function responses()
    {
        return $this->hasMany(Option::class, 'options_id');
    }

    // Your other existing relationships
    public function options()
    {
        return $this->belongsToMany(Option::class, 'response_options')->withTimestamps();
    }
}
