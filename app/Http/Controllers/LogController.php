<?php
namespace App\Http\Controllers;

use App\CourseLog;
use App\Http\Controllers\Controller;

class LogController extends Controller {
	public function show($id)
	{
		$logs = CourseLog::where('course_id', $id)->orderBy('created_at', 'desc')->paginate(10);
		
		return view('courseLogs.show', array('logs' => $logs));
	}
}