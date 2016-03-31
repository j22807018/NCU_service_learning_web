<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $table = 'questionnaires';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function course()
    {
    	return $this->belongsTo('App\Course', 'course_id');
    }
}
