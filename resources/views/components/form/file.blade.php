<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">
        {{ ucwords(str_replace(['_', '[]'], ' ', $name)) }}

        @if(!empty($attributes['required']))
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
        {{ Form::file($name, array_merge(['aria-describedby' => $name . '-error', 'aria-invalid' => 'false', 'id' => str_replace('[]', '', $name), 'multiple' => empty($attributes['multiple']) ? '' : 'multiple'])) }}
        <ul class='{{str_replace('[]', '', $name)}}-files mt-2'></ul>

        @if (empty($attributes['multiple']))
            @error(str_replace('[]', '', $name))
            <small class="text-danger">{{ $message }}</small>
            @enderror
        @endif

        @error(str_replace('[]', '.*', $name))
        <small class="text-danger">{{ $message }}</small>
        @enderror

        @error($name)
        <small class="text-danger">{{ $message }}</small>
        @enderror


    </div>

    @if(!empty($attributes['data-default']))
        <div class="offset-xs-4 col-xs-8 offset-sm-4 col-sm-8 offset-md-0 col-md-4 col-lg-4 col-xl-5 text-muted data-default-line-height" >
            {{ $attributes['data-default'] }}
        </div>
    @endif
</div>
