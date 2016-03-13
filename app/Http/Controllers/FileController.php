<?php
namespace App\Http\Controllers;

use Validator;
use App\File;
use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin', ['only' => ['upload', 'destroy']]);
    }

    public function upload(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $files = $request->file('upload_file');
        $is_login_need = $request->input('is_login_need');
        foreach ($files as $file) {
            if ($file->isValid()) {
                $title = urldecode($file->getClientOriginalName());
                $path = time() . '-' . str_random(20);

                $file->move(storage_path() . '/uploads/' . $course->id, $path);

                \App\File::forceCreate(['title' => $title, 'file_path' => $path,
                    'course_id' => $course->id, 'is_login_need' => $is_login_need, 'download_times' => 0]);
            }
        }
        return redirect()->route('course.index');
    }

    public function download($id)
    {
        $file = File::findOrFail($id);
        if ($file->is_login_need && !auth()->check())
            return redirect()->route('course.index');
        
        $header = [
            'Content-Type'              => 'application/octet-stream',
            'X-Content-Type-Options'    => 'nosniff',
            'X-Download-Options'        => 'noopen',
        ];
        $path = storage_path() . '/uploads/' . $file->course_id . '/' .$file->file_path;
        $file->download_times += 1;
        $file->save();
        return response()->download($path, $file->title, $header);
    }

    public function destroy($id)
    {
        if(($file = File::findOrFail($id)))
        {
            $path = storage_path() . '/uploads/' . $file->course_id . '/' .$file->file_path;
            if (file_exists($path)) {
                unlink($path);
            }
            if($file->delete())
                return redirect()->route('course.index');
        }
        return 'error';
    }
}