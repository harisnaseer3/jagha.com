<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">
        {{ ucwords(str_replace('_', ' ', $name)) }}

        @if(!empty($attributes['required']))
            <span class="text-danger">*</span>
        @endif
    </label>

    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
        {{ Form::number($name, $value, array_merge(['class' => 'form-control form-control-sm', 'aria-describedby' => $name . '-help', 'aria-invalid' => 'false'], $attributes)) }}
        <small id="{{$name}}-help" class="form-text text-muted">{{ !empty($attributes['data-help']) ? $attributes['data-help'] : '' }}</small>

        @error($name)
        <small class="text-danger">{{ $message }}</small>
        @enderror

    </div>

    @if(!empty($attributes['data-default']))
        <div class="offset-xs-4 col-xs-8 offset-sm-4 col-sm-8 offset-md-0 col-md-4 col-lg-4 col-xl-5 text-muted data-default-line-height my-sm-auto">
            {{ $attributes['data-default'] }}
        </div>
    @endif
</div>
