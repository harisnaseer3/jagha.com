<div class="modal fade" id="adminLogoutModal" tabindex="-1" role="dialog" aria-labelledby="adminLogoutModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
        <div class="modal-content">
            <div class="mr-2 mt-1">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div >
                    <p> You are logged in as admin ( <b>ID:</b> {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->id}} <b>Name: </b>{{\Illuminate\Support\Facades\Auth::guard('admin')->user()->name}}). To login as <b>user </b> logout of admin account first.</p>
                    <button type="submit" class="btn btn-block sign-in login-btn color-black sign-card" id="admin-logout-btn">
                        Logout
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
