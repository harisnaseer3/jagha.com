<div class="modal" tabindex="-1" role="dialog" id="status-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></a>

                <div class="text-center">
                    <p>Do you really want to @if($agency_user->is_active === '0')  activate @else deactivate @endif agency user account?</p>
                    {!! Form::open(['route' => ['agencies.destroy-user'], 'method' => 'delete']) !!}
                    <input type="hidden" id="agency-user-id" name="agency_user_id" />
                    <button type="submit"  class="btn btn-sm btn-success">Confirm</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
