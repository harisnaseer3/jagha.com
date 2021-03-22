@include('website.layouts.flash-message')

@if(isset($property))
    {{ Form::model($property,['route' => ['admin-properties-update', $property->id], 'method' => 'PUT', 'class'=> 'data-insertion-form', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
    @include('website.admin-pages.edit_fields_property_management')

@else
    {{ Form::open(['route' => 'admin-properties-store', 'method' => 'post', 'class'=> 'data-insertion-form', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
    @include('website.admin-pages.fields_property_management')
@endif


{{ Form::close() }}
<div class="modal fade" id="agenciesModalCenter" tabindex="-1" role="dialog" aria-labelledby="agenciesModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Select Agencies</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body" id="features-model">
                <div class="card my-2">
                    <div class="card-header theme-blue text-white">
                        Select Agency
                    </div>
                    <div class="card-body">
                        <table class="display" style="width: 100%" id="agencies-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>city</th>
                                <th>Address</th>
                                <th>Cell</th>
                                <th>Phone</th>
                                <th>Controls</th>
                            </tr>
                            </thead>
                            <tbody id="agencies-table-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{--@include('website.admin-pages.layouts.delete-image-modal', array('route'=>'images'))--}}
@include('website.admin-pages.layouts.delete-plan-modal', array('route'=>'floorPlans'))
@include('website.admin-pages.layouts.delete-video-modal', array('route'=>'videos'))

