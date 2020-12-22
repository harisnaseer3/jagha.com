<div class="form-group row">
    <label for="{{ $name }}" class="col-lg-2 col-sm-4 col-md-3 col-xl-2 col-form-label col-form-label-sm">
        {{ ucwords(str_replace(['_', '[]'], ' ', $name)) }}
        @if(!empty($attributes['required']))
            <span class="text-danger">*</span>
        @endif
    </label>

    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5" style="padding-top: calc(.25rem + 1px); padding-bottom: calc(.25rem + 1px);">
        @foreach($attributes['list'] as $k => $v)
            <div class="custom-control custom-checkbox {{ isset($attributes['display']) && $attributes['list'] === 'display' ? '' : 'custom-control-inline' }} d-flex align-items-center">
                <input class="custom-control-input" type="checkbox" name="{{ $name }}" id="{{ $name . '_' }}checkbox_{{ $k }}" value="{{ $v->id }}" aria-describedby="{{ $name }}-error"
                       @if (isset($v->name) && !empty($value)) {{in_array( $v->name, $value) ? 'checked' : '' }} @endif
                       @if(isset($value) && !empty($value))
                       {{in_array( $v->id, $value) ? 'checked' : ''}}
                       @endif
                       @if(!empty($attributes['required'])) required @endif>


                <label class="custom-control-label" for="{{ $name . '_' }}checkbox_{{ $k }}">{{ str_replace('_', ' ', $v->name) }}</label>
            </div>
        @endforeach
        @if ($name !== null)
            @error($name)
            <small class="text-danger">{{ $message }}</small>
            @enderror
        @endif
    </div>

    @if(!empty($attributes['data-default']))
        <div class="offset-xs-4 col-xs-8 offset-sm-4 col-sm-8 offset-md-0 col-md-4 col-lg-4 col-xl-5 text-muted data-deafult-line-height my-sm-auto">
            {{ $attributes['data-default'] }}
        </div>
    @endif
</div>
