@include('website.layouts.flash-message')
<div id="flash-msg" style="display: none"></div>
@if(isset($property))
    {{ Form::model($property,['route' => ['properties.update', $property->id], 'method' => 'PUT', 'class'=> 'data-insertion-form', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
    @include('website.pages.edit_fields_property_management')
    {{ Form::close() }}
@else
    {{ Form::open(['route' => 'properties.store', 'method' => 'post', 'class'=> 'data-insertion-form', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
    @include('website.pages.fields_property_management')
    {{ Form::close() }}
@endif


{{--@include('website.layouts.delete-image-modal', array('route'=>'images'))--}}
@include('website.layouts.delete-plan-modal', array('route'=>'floorPlans'))
@include('website.layouts.delete-video-modal', array('route'=>'videos'))

