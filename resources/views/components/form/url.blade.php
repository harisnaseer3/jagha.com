<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-4 col-md-2 col-form-label col-form-label-sm">
        {{ ucwords(str_replace('_', ' ', $name)) }}

        @if(!empty($attributes['required']))
            <span class="text-danger">*</span>
        @endif
    </label>

    <div class="col-sm-8 col-md-5">
        {{ Form::url($name, $value, array_merge(['class' => 'form-control form-control-sm', 'aria-describedby' => $name . '-error', 'aria-invalid' => 'false'], $attributes)) }}

        @error($name)
        <small class="text-danger">{{ $message }}</small>
        @enderror

    </div>

    @if(!empty($attributes['data-default']))
        <div class="offset-xs-4 col-xs-8 offset-sm-4 col-sm-8 offset-md-0 col-md-5 text-muted" style="padding-top: 0.375rem; padding-bottom: 0.375rem;">
            {{ $attributes['data-default'] }}
        </div>
    @endif
</div>
