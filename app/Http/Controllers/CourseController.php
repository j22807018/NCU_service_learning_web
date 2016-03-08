<?php

class CourseController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    public function __construct() {
        

    public function index()
    {
        $courses = Course::paginate(10);

        return view('layouts.index', array('courses' => $courses));
    }

    public function create()
    {
        $course = new Course;
        $course->is_for_student = Input::old('is_for_student');
        $course->is_for_teacher = Input::old('is_for_teacher');
        $course->is_for_staff = Input::old('is_for_staff');
        $course->is_announced = Input::old('is_announced');
        $course->title = Input::old('title');
        $course->message = Input::old('message');

        
        return view('courses.create', array('course' => $course));
    }

    public function store()
    {
        $is_for_student = Input::get('is_for_student');
        $is_for_teacher = Input::get('is_for_teacher');
        $is_for_staff = Input::get('is_for_staff');
        $is_announced = Input::get('is_announced');
        $title = Input::get('title');
        $message = Input::get('message');

        $validator = Validator::make(array(
            '標題' => $title,
            '內容' => $message),array(
            '標題' => 'required',
            '內容' => 'required'
        ));

        $course = new Course;
        if ($validator->fails())
        {
            return Redirect::route('course.create')->withInput()->withErrors($validator);
        }
        
        $course->is_for_student = $is_for_student;
        $course->is_for_teacher = $is_for_teacher;
        $course->is_for_staff = $is_for_staff;
        $course->is_announced = $is_announced;
        $course->title = $title;
        $course->message = $message;

        if ($course->save())
            return Redirect::route('course.index');
        else
            return 'create failed';
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
   
        return view('courses.show', array('course' => $course));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
      
        if(Input::old() != null){
            $course->is_for_student = Input::old('is_for_student');
            $course->is_for_teacher = Input::old('is_for_teacher');
            $course->is_for_staff = Input::old('is_for_staff');
            $course->is_announced = Input::old('is_announced');
            $course->title = Input::old('title');
            $course->message = Input::old('message');
        }
        return view('courses.create', array('course' => $course));
    }

    public function update($id)
    {
        $is_for_student = Input::get('is_for_student');
        $is_for_teacher = Input::get('is_for_teacher');
        $is_for_staff = Input::get('is_for_staff');
        $is_announced = Input::get('is_announced');
        $title = Input::get('title');
        $message = Input::get('message');

        $validator = Validator::make(array(
            '標題' => $title,
            '內容' => $message),array(
            '標題' => 'required',
            '內容' => 'required'
        ));

        $course = Course::findOrFail($id);

        if ($validator->fails())
        {
            return Redirect::route('course.edit', $id)->withInput()->withErrors($validator);
        }

        $course->is_for_student = $is_for_student;
        $course->is_for_teacher = $is_for_teacher;
        $course->is_for_staff = $is_for_staff;
        $course->is_announced = $is_announced;
        $course->title = $title;
        $course->message = $message;

        if ($course->save())
            return Redirect::route('course.show', $course->id);
        else
            return 'create failed';
    }

    public function destroy($id)
    {
        if(($course = Course::findOrFail($id)))
        {
            if($course->delete())
                return Redirect::route('course.index');
        }
        return 'error';
    }
}