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

        /*
        if (!is_null($answer)) {
            $value = $question->answers()->where('survey_entry_id', $answer)->first();
            $files = (!is_null($value)) ? File::whereIn('id', json_decode($value->value))->get() : new Collection();

            foreach ($files as $file)
            {
                $baseUrl = config("filesystems.disks.{$file->storage}.endpoint");
                $path = sprintf("%s/%s.%s", $file->path, $file->name, $file->extension);

                if ($file->visible)
                {

                    if ($file->storage === 'do')
                    {
                        $baseUrl = config("filesystems.disks.{$file->storage}.url");
                    }

                    $path = sprintf("%s%s", $baseUrl, $file->path);
                }
                else
                {
                    $s3 = new S3Client([
                        'version' => 'latest',
                        'region' => config("filesystems.disks.{$file->storage}.region"),
                        'endpoint' => rtrim($baseUrl, '/'),
                        'credentials' => [
                            'key'    => config("filesystems.disks.{$file->storage}.key"),
                            'secret' => config("filesystems.disks.{$file->storage}.secret"),
                        ],
                    ]);

                    $command = $s3->getCommand('GetObject', [
                        'Bucket' => config("filesystems.disks.{$file->storage}.bucket"),
                        'Key'    => trim($path, '/')
                    ]);

                    $path = $s3->createPresignedRequest($command, '+30 minutes')->getUri();
                }

                $this->answer[] = [
                    'name' => $file->filename,
                    'path' => $path
                ];
            }

        } else {
            $this->answer = null;
        }
        */
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
