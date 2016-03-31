<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    public function files()
    {
        return $this->hasMany('App\File', 'course_id');
    }

	public function courseLogs()
    {
        return $this->hasMany('App\CourseLog', 'course_id');
    }

    public function questionnaires()
    {
        return $this->hasMany('App\Questionnaire', 'course_id');
    }
}
