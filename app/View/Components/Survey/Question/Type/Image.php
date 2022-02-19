<?php

namespace App\View\Components\Survey\Question\Type;


use App\Models\File;
use App\Models\SurveyQuestion;
use Aws\S3\S3Client;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Image extends Component
{
    public SurveyQuestion $question;
    public array|null $answer;
    public string $componentId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(SurveyQuestion $question, int|null $answer = null)
    {
        $this->question = $question;
        $this->answer = json_decode($question->answers()->where('survey_entry_id', $answer)->first()?->value);

        $this->componentId = "QUESTION_IMAGE_".Str::upper(Str::random(6));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.survey.question.type.image');
    }
}
