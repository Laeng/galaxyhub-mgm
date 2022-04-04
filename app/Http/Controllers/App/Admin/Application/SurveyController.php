<?php

namespace App\Http\Controllers\App\Admin\Application;

use App\Http\Controllers\Controller;
use App\Services\Survey\Questions\QuizQuestion;
use Illuminate\Contracts\View\View;


class SurveyController extends Controller
{
    public function quiz(): View
    {
        $quiz = QuizQuestion::questionBank();

        return view('app.admin.application.quiz', [
            'quiz' => $quiz
        ]);
    }
}
