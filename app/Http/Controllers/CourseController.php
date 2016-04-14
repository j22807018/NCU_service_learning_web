<?php
namespace App\Http\Controllers;

use Validator;
use App\File;
use App\Course;
use App\CourseLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        if(auth()->check()){
            if(auth()->user()->is_admin){
                if($request->input('user') == 'for-student'){
                    $courses = Course::where('is_for_student', true)
                        ->paginate(15);
                } elseif ($request->input('user') == 'not-for-student') {
                    $courses = Course::where('is_for_student', false)
                        ->paginate(15);
                } else {
                    $courses = Course::paginate(15);
                }
            } else {
                if($request->input('user') == 'for-student'){
                    $courses = Course::where('is_for_student', true)
                        ->where('is_announced', true)
                        ->paginate(15);
                } elseif ($request->input('user') == 'not-for-student') {
                    $courses = Course::where('is_for_student', false)
                        ->where('is_announced', true)
                        ->paginate(15);
                } else {
                    $courses = Course::where('is_announced', true)
                        ->paginate(15);
                }
            }
        } else {
            if($request->input('user') == 'for-student'){
                $courses = Course::where('is_for_student', true)
                    ->where('is_announced', true)
                    ->where('is_login_need', false)
                    ->paginate(15);
            } elseif ($request->input('user') == 'not-for-student') {
                $courses = Course::where('is_for_student', false)
                    ->where('is_announced', true)
                    ->where('is_login_need', false)
                    ->paginate(15);
            } else {
                $courses = Course::where('is_login_need', false)
                    ->where('is_announced', true)
                    ->paginate(15);
            }
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
            $course->is_login_need = $request->old('is_login_need');
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
        $is_login_need = $request->input('is_login_need');

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
        $course->is_login_need = $is_login_need;

        if ($course->save())
            return redirect()->route('course.index');
        else
            return 'create failed';
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);

        if($course->is_login_need && !auth()->check())
            return redirect()->route('course.index');
        else if(!$course->is_announced && !auth()->user()->is_admin)
            return redirect()->route('course.index');
        else
            return view('courses.show', array('course' => $course));
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
            $course->is_login_need = $request->old('is_login_need');
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
        $is_login_need = $request->input('is_login_need');

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
            'message' => $course->message,
            'is_login_need' => $course->is_login_need
        );
        

        $course->is_for_student = $is_for_student;
        $course->is_for_teacher = $is_for_teacher;
        $course->is_for_staff = $is_for_staff;
        $course->is_announced = $is_announced;
        $course->title = $title;
        $course->message = $message;
        $course->is_login_need = $is_login_need;

        if ($course->save()){
            $modifications = array(
                'user_origin'=> "",
                'title_origin' => null,
                'message_origin' => null,
                'is_announced_origin' => null,
                'is_login_need_origin' => null,
                'user_new'=> "",
                'title_new' => null,
                'message_new' => null,
                'is_announced_new' => null,
                'is_login_need_new' => null,
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
            if($modifications['user_origin'] == $modifications['user_new']){
                $modifications['user_origin'] = null;
                $modifications['user_new'] = null;
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
            if($course->is_login_need != $old_data['is_login_need']){
                $modifications['is_login_need_origin'] = $old_data['is_login_need'];
                $modifications['is_login_need_new'] = $course->is_login_need;
                $count++;
            }

            if($count > 0){
                $modifications['update_time'] = $course->updated_at->toDateString();

                $log = new CourseLog;
                $log->course_id = $course->id;
                $log->editor_id = auth()->user()->id;
                $log->modifications = json_encode($modifications);
                $log->save();
            }
            return redirect()->route('course.show', $course->id);
        }
        else
            return 'create failed';
    }

    public function destroy($id)
    {
        if($course = Course::findOrFail($id))
        {
            foreach ($course->files as $file) {
                $path = storage_path() . '/uploads/' . $file->course_id . '/' .$file->file_path;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            if($course->delete())
                return redirect()->route('course.index');
        }
        return 'error';
    }

    public function announce($id)
    {
        if($course = Course::findOrFail($id))
        {
            $course->is_announced = true;
            $course->announce_date = Carbon::today()->toDateString();
        }
        if ($course->save()) {
            $modifications = array(
                'user_origin'=> "",
                'title_origin' => null,
                'message_origin' => null,
                'is_announced_origin' => null,
                'is_login_need_origin' => null,
                'user_new'=> "",
                'title_new' => null,
                'message_new' => null,
                'is_announced_new' => null,
                'is_login_need_new' => null,
                'update_time' => null
            );
            $modifications['is_announced_origin'] = false;
            $modifications['is_announced_new'] = true;
            $modifications['update_time'] = $course->updated_at->toDateString();

            $log = new CourseLog;

            $log->course_id = $course->id;
            $log->editor_id = auth()->user()->id;
            $log->modifications = json_encode($modifications);
            $log->save();

            return redirect()->route('course.show', $course->id);
        }
        else
            return 'announce failed';
    }
    
    public function hide($id)
    {
        if($course = Course::findOrFail($id))
        {
            $course->is_announced = false;
            $course->announce_date = 0;
        }
        if ($course->save()){
            $modifications = array(
                'user_origin'=> "",
                'title_origin' => null,
                'message_origin' => null,
                'is_announced_origin' => null,
                'is_login_need_origin' => null,
                'user_new'=> "",
                'title_new' => null,
                'message_new' => null,
                'is_announced_new' => null,
                'is_login_need_new' => null,
                'update_time' => null
            );
            $modifications['is_announced_origin'] = true;
            $modifications['is_announced_new'] = false;
            $modifications['update_time'] = $course->updated_at->toDateString();

            $log = new CourseLog;
            $log->course_id = $course->id;
            $log->editor_id = auth()->user()->id;
            $log->modifications = json_encode($modifications);
            $log->save();
            return redirect()->route('course.show', $course->id);
        }
        else
            return 'hide failed';
    }
}