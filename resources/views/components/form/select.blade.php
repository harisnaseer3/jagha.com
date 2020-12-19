<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">
        {{ ucwords(str_replace('_', ' ', $name)) }}

        @if(!empty($selectAttributes['required']))
            <span class="text-danger">*</span>
        @endif
    </label>

    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
        {{ Form::select($name, $list, $selected, array_merge(['class' => 'custom-select custom-select-sm', 'aria-describedby' => $name . '-error', 'aria-invalid' => 'false'], $selectAttributes), $optionsAttributes, $optgroupsAttributes) }}

        @error($name)
        <small class="text-danger">{{ $message }}</small>
        @enderror

    </div>

    @if(!empty($selectAttributes['data-default']))
        <div class="offset-xs-4 col-xs-8 offset-sm-4 col-sm-8 offset-md-0 col-md-4 col-lg-4 col-xl-5 text-muted data-default-line-height">
            {{ $selectAttributes['data-default'] }}
        </div>
    @endif
</div>
