<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Collective\Html\FormBuilder as Form;

class FormGroupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('bsCheckbox', 'components.form.checkbox', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsDate', 'components.form.date', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsEmail', 'components.form.email', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsFile', 'components.form.file', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsHidden', 'components.form.hidden', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsNumber', 'components.form.number', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsPassword', 'components.form.password', ['name', 'attributes' => []]);
        Form::component('bsRadio', 'components.form.radio', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsSelect', 'components.form.select', ['name', 'list' => [], 'selected' => null, 'selectAttributes' => [], 'optionsAttributes' => [], 'optgroupsAttributes' => []]);
        Form::component('bsSelect2', 'components.form.select2', ['name', 'list' => [], 'selected' => null, 'selectAttributes' => [], 'optionsAttributes' => [], 'optgroupsAttributes' => []]);
        Form::component('bsTel', 'components.form.tel', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsText', 'components.form.text', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsTextArea', 'components.form.textArea', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsTime', 'components.form.time', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsUrl', 'components.form.url', ['name', 'value' => null, 'attributes' => []]);
    }
}
