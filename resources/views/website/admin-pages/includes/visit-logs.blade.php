<div class="col-12 mb-4">
    <div class="card">
        <div class="card-header theme-blue text-white">
            User Visit Log  <span class="spinner-border" role="status" aria-hidden="true" id="loader-visit-logs"></span>
        </div>
        <div class="card-body" style="display: none" id="visit-logs-block">
            <table id="user-log" class="display" style="width: 100%">
                <thead>
                <tr>
                    <th>Sr.</th>
                    <th>IP</th>
                    <th>IP Location</th>
                    <th>Date</th>
                    <th>Visit Count</th>
                    {{--                                                                    <th>Time</th>--}}
                </tr>
                </thead>
                <tbody  id="tbody-visit-logs"></tbody>
            </table>
        </div>
    </div>
</div>
