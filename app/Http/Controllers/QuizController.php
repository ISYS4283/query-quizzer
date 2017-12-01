<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;
use Auth;
use App\Attempt;
use jpuck\php\bootstrap\ProgressBar\ProgressBar;
use App\Blackboard;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Quiz::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Quiz::class);

        return view('quizzes.index', [
            'title' => 'Quizzes',
            'quizzes' => Quiz::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quiz = Quiz::create($request->all());

        if (isset($quiz->blackboard_course_id)) {
            (new Blackboard($quiz))->createGradebookColumn();
        }

        return redirect(route('quizzes.show', $quiz));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        $completed = Attempt::where('user_id', Auth::user()->id)
            ->where('quiz_id', $quiz->id)
            ->where('valid', true)->get();

        $queries = $quiz->queries->map(function ($query) use ($completed) {
            $query->completed = false;
            if ($completed->contains('query_id', $query->id)) {
                $query->completed = true;
            }
            return $query;
        });

        return view('quizzes.show', [
            'title' => "Quiz #{$quiz->id}: {$quiz->title}",
            'quiz' => $quiz,
            'queries' => $queries,
            'progressBar' => $this->getProgressBar($completed, $queries),
        ]);
    }

    protected function getProgressBar($completed, $queries) : ProgressBar
    {
        if ($completed->isEmpty()) {
            return new ProgressBar(0);
        }

        $points = 0;
        foreach ($completed as $attempt) {
            $points += $attempt->qq->points;
        }

        $total = 0;
        foreach ($queries as $query) {
            $total += $query->pivot->points;
        }

        $percent = (int)round(($points / $total) * 100);

        return new ProgressBar($percent);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
