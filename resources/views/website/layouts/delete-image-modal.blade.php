<div class="modal" tabindex="-1" role="dialog" id="delete-image">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></a>
                <div class="text-center">
                    <i class="far fa-trash-alt fa-3x text-red mt-2 mb-2"></i>
                </div>
                <div class="text-center">
                    <p>Do you really want to delete this Image</p>
                    {!! Form::open(['route' => [$route.'.destroy', 0], 'method' => 'delete']) !!}
                    <input type="hidden" id="image-record-id" value="" name="image-record-id"/>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
