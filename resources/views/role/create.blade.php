@extends('layouts.app')


@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <a class="btn btn-sm btn-info" href="{{route('roles.index')}}">
                            <i class="fas fa-1x fa-arrow-left"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                @include('layouts.flash-message')

                <div class="card">
                    <div class="card-header">
                        <h5 class="text-dark fa-pull-left mt-1">{{ ucwords($table_name) }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'roles.store', 'class'=> 'data-insertion-form']) !!}

                        {{ Form::bsText('name', null,  ['required' => true, 'data-default' => 'e.g. admin']) }}

                        <div class="form-group">
                            <button class="btn btn-warning" type="reset">Reset</button>
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/script-role.js')}}"></script>
@endsection
