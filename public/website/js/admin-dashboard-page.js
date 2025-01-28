(function ($) {
    $(document).ready(function () {

        $.get('/get-admin-logs',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-admin-logs').hide();
                $('#admins-logs-block').slideDown();
                $('#tbody-admin-logs').html(data.view);

                $('#admin-log').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
            }
        );
        $.get('/get-property-logs',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-property-logs').hide();
                $('#property-logs-block').slideDown();
                $('#tbody-property-logs').html(data.view);

                $('#property-log').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
            }
        );
        $.get('/get-agency-logs',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-agency-logs').hide();
                $('#agency-logs-block').slideDown();
                $('#tbody-agency-logs').html(data.view);

                $('#agency-log').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
            }
        );
        $.get('/get-visit-logs',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-visit-logs').hide();
                $('#visit-logs-block').slideDown();
                $('#tbody-visit-logs').html(data.view);

                // $('#user-log').DataTable({
                //     "scrollX": true,
                //     "ordering": false,
                //     responsive: true
                // });

                $('#user-log').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/get-visit-logs",
                    "columns": [
                        { "data": "id" },
                        { "data": "ip" },
                        { "data": "ip_location" },
                        { "data": "date" },
                        { "data": "count" },
                    ],
                    "scrollX": true,
                    "ordering": false,
                    "responsive": true
                });
            }
        );
        $.get('/get-package-logs',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-package-logs').hide();
                $('#package-logs-block').slideDown();
                $('#tbody-package-logs').html(data.view);

                $('#package-log').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
            }
        );

        if ($('#myChart').length > 0) {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/admin-user-count',
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        if (data.data.date !== null && data.data.total_count !== null) {
                            drawGraph(data.data.date, data.data.total_count, data.data.unique_count);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(error);
                    // console.log(status);
                    // console.log(xhr);
                },
                complete: function (url, options) {
                }
            });
        }

        function drawGraph(label, data1, data2) {
            //data1 = total count, data2 = unique count
            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: label,
                    datasets: [{
                        label: 'Total Visits',
                        data: data1,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 2
                    }, {
                        label: 'Unique Visits Count',
                        data: data2,
                        backgroundColor: [
                            'rgba(75, 192, 192, 1)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 2
                    }
                    ]
                },
                options: {
                    tooltips: {
                        mode: 'index'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }

        $('#execute-tasks').on('click', function () {
            $('.fa-spinner').show();
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/admin-cron-job',
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        if (data.data === 'success') {
                            $('.fa-spinner').hide();
                            alert('Daily jobs executed successfully');

                        } else alert('Error executing daily task. Please try again.');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                    console.log(status);
                    console.log(xhr);
                },
                complete: function (url, options) {
                }
            });
        });
        $(document).on('click', '.form-history-btn', function () {
            $('input[name=packId]').val($(this).data('attr'));
            $('#history-form').submit();
        });

    });
})
(jQuery);
