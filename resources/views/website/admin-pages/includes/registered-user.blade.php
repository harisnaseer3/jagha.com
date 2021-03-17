<div class="col-12 mb-4">
    <div class="card">
        <div class="card-header theme-blue text-white">
            Registered User <span class="spinner-border" role="status" aria-hidden="true" id="loader-reg-user"></span>
        </div>
        <div class="card-body" style="display: none" id="reg-user-block">
            <table id="reg_users" class="display" style="width: 100%">
                <thead>
                <tr>
                    <th>Sr.</th>
                    <th>{{ __('Name') }}</th>
                    <th>Community Nick</th>
                    <th>{{ __('E-Mail Address') }}</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Address</th>

                    <th>{{ __('Status') }}</th>
                    <th>Action</th>
                    {{--                                <th>Action</th>--}}
                </tr>
                </thead>
                <tbody id="tbody-reg-user"></tbody>
            </table>
        </div>
    </div>
</div>
