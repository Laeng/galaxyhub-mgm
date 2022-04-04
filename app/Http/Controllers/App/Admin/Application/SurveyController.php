<?php

namespace App\Http\Controllers\App\Admin\Application;

use App\Http\Controllers\Controller;
use App\Services\Survey\Questions\ApplicationQuestion;
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

    public function form(): View
    {
        $form = [
            [
                'type' => 'section',
                'contents' => ApplicationQuestion::questionNotice()[0]
            ],
            [
                'type' => 'question',
                'contents' => ApplicationQuestion::questionPart1()
            ],
            [
                'type' => 'section',
                'contents' => ApplicationQuestion::questionNotice()[1]
            ],
            [
                'type' => 'question',
                'contents' => ApplicationQuestion::questionPart2()
            ]
        ];

        return view('app.admin.application.form', [
            'form' => $form
        ]);
    }
}
