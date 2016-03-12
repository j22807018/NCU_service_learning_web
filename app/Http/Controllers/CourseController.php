<?php
namespace App\Http\Controllers;

use Validator;
use App\File;
use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index()
    {
        $courses = Course::paginate(5);

        return view('layouts.index', array('courses' => $courses));
    }

    public function create()
    {
        $course = new Course;
        $request = request();
        if($request->old() != null){
            $course->is_for_student = $request->old('is_for_student');
            $course->is_for_teacher = $request->old('is_for_teacher');
            $course->is_for_staff = $request->old('is_for_staff');
            $course->title = $request->old('title');
            $course->message = $request->old('message');
        }
        return view('courses.create', array('course' => $course));
    }

    public function store(Request $request)
    {
        // $user = $request->input('user');
        $is_for_student = $request->input('is_for_student');
        $is_for_teacher = $request->input('is_for_teacher');
        $is_for_staff = $request->input('is_for_staff');
        $title = $request->input('title');
        $message = $request->input('message');

        $validator = Validator::make(array(
            '標題' => $title,
            '內容' => $message),array(
            '標題' => 'required',
            '內容' => 'required',
        ));

        $course = new Course;
        if ($validator->fails())
        {
            return redirect()->route('course.create')->withInput()->withErrors($validator);
        }

        $course->is_for_student = $is_for_student;
        $course->is_for_teacher = $is_for_teacher;
        $course->is_for_staff = $is_for_staff;
        $course->is_announced = false;
        $course->title = $title;
        $course->message = $message;

        if ($course->save())
            return redirect()->route('course.index');
        else
            return 'create failed';
    }

    public function show($id)
    {
        $courses = Course::paginate(10);

        return view('layouts.index', array('courses' => $courses));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $request = request();
        if($request->old() != null){
            $course->is_for_student = $request->old('is_for_student');
            $course->is_for_teacher = $request->old('is_for_teacher');
            $course->is_for_staff = $request->old('is_for_staff');
            $course->title = $request->old('title');
            $course->message = $request->old('message');
        }
        return view('courses.create', array('course' => $course));
    }

    public function update(Request $request, $id)
    {
        $is_for_student = $request->input('is_for_student');
        $is_for_teacher = $request->input('is_for_teacher');
        $is_for_staff = $request->input('is_for_staff');
        $is_announced = $request->input('is_announced');
        $title = $request->input('title');
        $message = $request->input('message');

        $validator = Validator::make(array(
            '標題' => $title,
            '內容' => $message),array(
            '標題' => 'required',
            '內容' => 'required'
        ));

        $course = Course::findOrFail($id);

        if ($validator->fails())
        {
            return redirect()->route('course.edit', $id)->withInput()->withErrors($validator);
        }

        $course->is_for_student = $is_for_student;
        $course->is_for_teacher = $is_for_teacher;
        $course->is_for_staff = $is_for_staff;
        $course->is_announced = $is_announced;
        $course->title = $title;
        $course->message = $message;

        if ($course->save())
            return redirect()->route('course.index', $course->id);
        else
            return 'create failed';
    }

    public function destroy($id)
    {
        if(($course = Course::findOrFail($id)))
        {
            if($course->delete())
                return redirect()->route('course.index');
        }
        return 'error';
    }
}