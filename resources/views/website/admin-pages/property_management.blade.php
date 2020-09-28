@include('website.layouts.flash-message')

@if(isset($property))
    {{ Form::model($property,['route' => ['admin-properties-update', $property->id], 'method' => 'PUT', 'class'=> 'data-insertion-form', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
@else
    {{ Form::open(['route' => 'properties.store', 'method' => 'post', 'class'=> 'data-insertion-form', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
@endif

@include('website.admin-pages.fields_property_management')

{{ Form::close() }}

@include('website.admin-pages.layouts.delete-image-modal', array('route'=>'images'))
@include('website.admin-pages.layouts.delete-plan-modal', array('route'=>'floorPlans'))
@include('website.admin-pages.layouts.delete-video-modal', array('route'=>'videos'))

