<?php

namespace App\Providers;

use App\Action\Survey\SurveyForm;
use App\Action\Survey\SurveyFormContract;
use Illuminate\Support\ServiceProvider;

class SurveyFormProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SurveyFormContract::class, function (){
            return new SurveyForm();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides(): array
    {
        return [SurveyForm::class];
    }
}
