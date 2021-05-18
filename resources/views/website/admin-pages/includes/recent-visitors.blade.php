<div class="col-12 mb-4">
    <div class="card">
        <div class="card-header theme-blue text-white">
            Recent Visitors <span class="spinner-border" role="status" aria-hidden="true" id="loader-recent-visitors"></span>
        </div>
        <div class="card-body" style="display: none" id="recent-visitors-block">
            <table id="recent-visitors" class="display" style="width: 100%">
                <thead>
                <tr>
                    <th>Browser</th>
                    <th>Country</th>
                    {{--                    <th>City</th>--}}
                    <th>Date</th>
                    <th>IP</th>
                    <th>Referer</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tbody-recent-visitors">

                </tbody>
            </table>
            <form method="post" id="history-form" action="{{route('admin.statistic.history')}}">
                @csrf
                <input type="hidden" name="ip" value="">
                <input type="hidden" name="date" value="">
            </form>
            <div id="custom-recent-visitor-date" class="float-right mt-2">
                <input type="date" size="18" name="date-on" data-wps-date-picker="from" value="" autocomplete="off" id="recent-visitor-dp">
                <input type="submit" id="recent-visitor-submit" value="Go" data-between-chart-show="hits" class="btn btn-sm btn-primary p-2 m-0">
            </div>
        </div>
    </div>
</div>
