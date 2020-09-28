

@if(isset($admin))
    <div class="form-group row">
        <div class="col-md-6">
            {!! Form::label('role', __('Role') ) !!} <span class="text-danger">*</span>
            <select name="role" class="form-control form-control-sm" style="width: 100%;" tabindex="-1" aria-hidden="true" id="select-admin-role" autofocus>
                <option value selected disabled>Select Role</option>
                @foreach($roles as $role)
                    @if($role->name !== 'Super Admin')
                        <option @if($role->name === $admin_role ) selected @endif value="{{$role->name}}"> {{$role->name}} </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
@endif

<div class="form-group row">
    <div class="col-md-12">
        {!! Form::label('name', __('Name') ) !!} <span class="text-danger">*</span>
    </div>
    <div class="col-md-6">
        <input id="name" type="text"
               class="form-control form-control-sm @error('name') is-invalid @enderror" name="name"
               @if (isset($user)) value="{{ $user->name }}" @elseif (isset($admin)) value="{{ $admin->name }}" @endif required autocomplete="name" autofocus>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col-md-6">
{{--        <div id="nameHelp" class="form-text text-gray">{{ __('crud.for_example') }} {{ __('models/user_management.sample_name') }}</div>--}}
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        {!! Form::label('email', __('E-Mail Address') ) !!} <span class="text-danger">*</span>
    </div>
    <div class="col-md-6">
        <input id="email" type="email"
               class="form-control form-control-sm @error('email') is-invalid @enderror" name="email"
               @if (isset($user)) value="{{ $user->email }}" @elseif (isset($admin)) value="{{ $admin->email }}" @endif required autocomplete="email">
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col-md-6">
{{--        <div id="emailHelp" class="form-text text-gray">{{ __('crud.for_example') }} {{ __('models/user_management.sample_email') }}</div>--}}
    </div>
</div>

<!-- Submit Field -->
<div class="form-group row">
    <div class="col-md-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('admin.manage-users') }}" class="btn btn-danger">Cancel</a>
    </div>
</div>
