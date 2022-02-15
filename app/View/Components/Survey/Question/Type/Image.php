<?php

namespace App\View\Components\Survey\Question\Type;


use App\Models\File as FileModel;
use App\Models\SurveyQuestion;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Image extends Component
{
    public SurveyQuestion $question;
    public string|array|null $answer;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(SurveyQuestion $question, int|null $answer = null)
    {
        $this->question = $question;

        if (!is_null($answer)) {
            $value = $question->answers()->where('survey_entry_id', $answer)->first();
            $this->answer = (!is_null($value)) ? FileModel::whereIn('id', json_decode($value->value))->get() : new Collection();

        } else {
            $this->answer = null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.survey.question.type.image', [
            'url' => config('filesystems.disks.do.url') // S3에서만 처리하도록 했으므로 하드코딩
        ]);
    }
}
