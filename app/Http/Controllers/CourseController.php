<?php
namespace App\Http\Controllers;

use Validator;
use App\File;
use App\Course;
use App\CourseLog;
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

    public function index(Request $request)
    {
        if($request->input('user') == 'for-student'){
            $courses = Course::where('is_for_student', '=', true)->paginate(5);
        } elseif ($request->input('user') == 'not-for-student') {
            $courses = Course::where('is_for_student', '=', false)->paginate(5);
        } else {
            $courses = Course::paginate(5);
        }    

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
        return redirect()->route('course.index');
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

        $old_data = array(
            'is_for_student' => $course->is_for_student,
            'is_for_teacher' => $course->is_for_teacher,
            'is_for_staff' => $course->is_for_staff,
            'is_announced' => $course->is_announced,
            'title' => $course->title,
            'message' => $course->message
        );
        

        $course->is_for_student = $is_for_student;
        $course->is_for_teacher = $is_for_teacher;
        $course->is_for_staff = $is_for_staff;
        $course->is_announced = $is_announced;
        $course->title = $title;
        $course->message = $message;

        if ($course->save()){
            $modifications = array(
                'user_origin'=> "",
                'title_origin' => null,
                'message_origin' => null,
                'user_new'=> "",
                'title_new' => null,
                'message_new' => null,
                'update_time' => null
            );

            $count = 0;
            if($course->is_for_student != $old_data['is_for_student']){
                if($old_data['is_for_student']){
                    $modifications['user_origin'] = $modifications['user_origin']."學生 ";
                } else{
                    $modifications['user_new'] = $modifications['user_new']."學生 ";
                }
                $count++;
            } elseif ($course->is_for_student == true) {
                $modifications['user_origin'] = $modifications['user_origin']."學生 ";
                $modifications['user_new'] = $modifications['user_new']."學生 ";
            }
            if($course->is_for_teacher != $old_data['is_for_teacher']){
                if($old_data['is_for_teacher']){
                    $modifications['user_origin'] = $modifications['user_origin']."教師 ";
                } else{
                    $modifications['user_new'] = $modifications['user_new']."教師 ";
                }
                $count++;
            } elseif ($course->is_for_teacher == true) {
                $modifications['user_origin'] = $modifications['user_origin']."教師 ";
                $modifications['user_new'] = $modifications['user_new']."教師 ";
            }
            if($course->is_for_staff != $old_data['is_for_staff']){
                if($old_data['is_for_staff']){
                    $modifications['user_origin'] = $modifications['user_origin']."職員 ";
                } else{
                    $modifications['user_new'] = $modifications['user_new']."職員 ";
                }
                $count++;
            } elseif ($course->is_for_staff == true) {
                $modifications['user_origin'] = $modifications['user_origin']."職員 ";
                $modifications['user_new'] = $modifications['user_new']."職員 ";
            }
            if($course->title != $old_data['title']){
                $modifications['title_origin'] = $old_data['title'];
                $modifications['title_new'] = $course->title;
                $count++;
            }
            if($course->message != $old_data['message']){
                $modifications['message_origin'] = $old_data['message'];
                $modifications['message_new'] = $course->message;
                $count++;
            }

            if($count != 0){
                $modifications['update_time'] = $course->updated_at->toDateString();

                $log = new CourseLog;
                $log->course_id = $course->id;
                $log->editor_id = auth()->user()->id;
                $log->modifications = json_encode($modifications);
                $log->save();
            }
            return redirect()->route('course.index');
        }
        else
            return 'create failed';
    }

    public function destroy($id)
    {
        if(($course = Course::findOrFail($id)))
        {
            foreach ($course->files as $file) {
                $path = storage_path() . '/uploads/' . $file->course_id . '/' .$file->file_path;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            if($course->delete())
                return redirect()->back();
        }
        return 'error';
    }
}