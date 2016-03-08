<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    public function files()
    {
        return $this->hasMany('app/File', 'course_id');
    }
}
