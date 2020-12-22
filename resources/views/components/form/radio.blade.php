<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">
        {{ ucwords(str_replace('_', ' ', $name)) }}
        @if(!empty($attributes['required']))
            <span class="text-danger">*</span>
        @endif
    </label>

    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5" style="padding-top: calc(.25rem + 1px); padding-bottom: calc(.25rem + 1px);">
        <div class="row">





        @foreach($attributes['list'] as $k => $v)
                <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="custom-control custom-radio custom-control-inline align-items-center">
                <input class="custom-control-input" type="radio" name="{{ $name }}" id="{{ $name }}_radio_{{ $k }}"
                       value="{{ $v }}" aria-describedby="{{ $name }}-error" @if($v === $value) {{ 'checked' }} @endif @if(!empty($attributes['required'])) required @endif>
                <label class="custom-control-label" style="line-height:1.2rem;" for="{{ $name }}_radio_{{ $k }}">
                    @if ($v === '1') {{ 'Yes' }} @elseif ($v === '0') {{ 'No' }} @else {{ $v }} @endif</label>
            </div>
                </div>
        @endforeach
        @error($name)
        <small class="text-danger">{{ $message }}</small>
        @enderror
        </div>

    </div>

    @if(!empty($attributes['data-default']))
        <div class="offset-xs-4 col-xs-8 offset-sm-4 col-sm-8 offset-md-0 col-md-4 col-lg-4 col-xl-5 text-muted data-default-line-height my-auto">
            {{ $attributes['data-default'] }}
        </div>
    @endif
</div>
