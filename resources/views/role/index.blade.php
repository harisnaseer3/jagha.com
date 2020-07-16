@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <a class="btn btn-sm btn-info fa-pull-left" href="{{route('home')}}">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-sm btn-info fa-pull-right" id="add-new-btn" href="{{route('roles.create')}}">
                            <i class="fas fa-plus"></i>
                            Add New Role
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
                    <h5 class="card-header text-dark">{{ ucwords($table_name) }}</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped index-table">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($table_data_values as $data_values)
                                    <tr>
                                        @foreach($data_values->getAttributes() as $key => $value)
                                            <td>
                                                {{$value}}
                                            </td>
                                        @endforeach
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Button Group">
                                                @can('delete-users')
                                                    <a type="button" class="btn btn-danger" data-toggle-1="tooltip" data-placement="bottom" title="delete"
                                                       data-toggle="modal" data-target="#delete"
                                                       data-record-id="{{$data_values->id}}">
                                                        <i class="far fa-trash-alt text-white" aria-hidden="true"></i>
                                                    </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--modal--}}
    @include('layouts.delete-modal', array('table_name'=>$table_name))
@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    <script src="{{asset('js/script-user-show.js')}}"></script>
@endsection
