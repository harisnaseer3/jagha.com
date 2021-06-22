<div class="col-12 mb-4">
    <div class="card">
        <div class="card-header theme-blue text-white">
            Package Log <span class="spinner-border" role="status" aria-hidden="true" id="loader-package-logs"></span>
        </div>
        <div class="card-body" style="display: none" id="package-logs-block">
            <table id="package-log" class="display" style="width: 100%">
                <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Package Type</th>
                    <th>Cost (Rs.)</th>
                    <th>Status</th>
                    <th>Complementary</th>
                    <th>Activation</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody id="tbody-package-logs">

                </tbody>
                <form method="post" id="history-form" action="{{route('admin.package.history')}}">
                    @csrf
                    <input type="hidden" name="packId" value="">
                </form>
            </table>
        </div>
    </div>
</div>
