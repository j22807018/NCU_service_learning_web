<?php
namespace App\Http\Controllers;

use App\Questionnaire;
use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller {
	public function __construct() {
        $this->middleware('admin', ['only' => ['index', 'show']]);
    }

	public function index()
	{
		$courses = Course::paginate(15);
		return view('questionnaires.index', array('courses' => $courses));
	}

	public function store(Request $request, $id)
	{
		$satisfaction = $request->input('satisfaction');

		if($satisfaction != 0) {
			$questionnaire = new Questionnaire;
			if( auth()->check() ) {
				$questionnaire->user_id = auth()->user()->id;
			}

			$questionnaire->course_id = $id;
			$questionnaire->satisfaction = $satisfaction;

			$questionnaire->save();

			return redirect()->back();
		}
	}

	public function show($id)
	{
		$questionnaires = Questionnaire::where('course_id', $id)->orderBy('created_at', 'desc')->paginate(10);
		
		return view('questionnaires.show', array('questionnaires' => $questionnaires));
	}
}