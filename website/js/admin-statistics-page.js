(function ($) {
    $(document).ready(function () {
        let dp1 = $('#dp1');
        let dp2 = $('#dp2');
        dp1.datepicker({
            dateFormat: "yy-mm-dd",
            allowInputToggle: true,
            defaultDate: -15
        }).datepicker("setDate", -15);
        dp2.datepicker({
            dateFormat: "yy-mm-dd",
            allowInputToggle: true,
            defaultDate: new Date()

        }).datepicker("setDate", new Date());


        $('#custom-hit').on('click', function () {
            $('#custom-date').slideToggle();
        });
        $('#custom-platform-hit').on('click', function () {
            $('#custom-platform-date').slideToggle();
        });
        $('#custom-browser-hit').on('click', function () {
            $('#custom-browser-date').slideToggle();
        });

        if ($('#myChart').length > 0) {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/admin-hit-count',
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        if (data.data.date !== null && data.data.visits !== null) {

                            $('#loader-stats').hide();
                            $('#stats-block').slideDown();
                            drawGraph(data.data.date, data.data.visits, data.data.visitors);

                        }
                    }
                }
            });
        }


        if ($('#browserChart').length > 0) {
            let ctx = document.getElementById("browserChart").getContext('2d');
            drawPieChart(ctx);

            // jQuery.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // jQuery.ajax({
            //     type: 'post',
            //     url: window.location.origin + '/top-browsers',
            //     dataType: 'json',
            //     success: function (data) {
            //         if (data.status === 200) {
            //             if (data.data.date !== null && data.data.visits !== null) {
            //                 drawGraph(data.data.date, data.data.visits, data.data.visitors);
            //
            //                 drawPieChart( ctx, labels, data);
            //             }
            //         }
            //     }
            // });
        }
        if ($('#platformChart').length > 0) {
            let ctx = document.getElementById("platformChart").getContext('2d');
            drawPieChart(ctx);

            // jQuery.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // jQuery.ajax({
            //     type: 'post',
            //     url: window.location.origin + '/top-browsers',
            //     dataType: 'json',
            //     success: function (data) {
            //         if (data.status === 200) {
            //             if (data.data.date !== null && data.data.visits !== null) {
            //                 // drawGraph(data.data.date, data.data.visits, data.data.visitors);
            // drawPieChart( ctx, labels, data);
            //
            //             }
            //         }
            //     }
            // });
        }

        $.get('/get-top-pages',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-top-pages').hide();
                $('#top-pages-block').slideDown();
                $('#tbody-top-pages').html(data.view);

                $('#top-pages').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
            }
        );
        $.get('/get-top-countries',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-top-countries').hide();
                $('#top-countries-block').slideDown();
                $('#tbody-top-countries').html(data.view);

                $('#top-countries').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
            }
        );


        $('#submit').on('click', function (e) {
            $("canvas#myChart").remove();
            $("div#chart-block").append('<canvas id="myChart" class="w-100" height="300px"></canvas>');

            e.preventDefault();
            let dp1_date = dp1.datepicker('getDate');
            let from = '';
            let to = '';
            if (dp1_date !== null) { // if any date selected in datepicker
                let date = dp1_date.getDate();
                if (date < 10)
                    date = 0 + '' + date;
                let month = (dp1_date.getMonth() + 1);
                if (month < 10)
                    month = 0 + '' + month;
                from = dp1_date.getFullYear() + '-' + month + '-' + date;
            } else
                alert('Please select valid date');
            let dp2_date = dp2.datepicker('getDate');
            if (dp2_date !== null) { // if any date selected in datepicker
                let date = dp2_date.getDate();
                if (date < 10)
                    date = 0 + '' + date;
                let month = (dp2_date.getMonth() + 1);
                if (month < 10)
                    month = 0 + '' + month;

                to = dp2_date.getFullYear() + '-' + month + '-' + date;
            } else
                alert('Please select valid some date');

            if (Date.parse(from) > Date.parse(to)) {
                let temp = from;
                from = to;
                to = temp;
            }

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/admin-hit-count',
                data: {'from': from, 'to': to},
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        if (data.data.date !== null && data.data.visits !== null) {
                            drawGraph(data.data.date, data.data.visits, data.data.visitors);
                        }
                    }
                }
            });
        });

        $('#year-hit').on('click', function (e) {
            $("canvas#myChart").remove();
            $("div#chart-block").append('<canvas id="myChart" class="w-100" height="300px"></canvas>');
            e.preventDefault();
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/admin-hit-count',
                data: {'time': 'year'},
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        if (data.data.date !== null && data.data.visits !== null) {
                            drawGraph(data.data.date, data.data.visits, data.data.visitors);
                        }
                    }
                }
            });


        });
        $('#week-hit').on('click', function (e) {
            $("canvas#myChart").remove();
            $("div#chart-block").append('<canvas id="myChart" class="w-100" height="300px"></canvas>');
            e.preventDefault();
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/admin-hit-count',
                data: {'time': 'week'},
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        if (data.data.date !== null && data.data.visits !== null) {
                            drawGraph(data.data.date, data.data.visits, data.data.visitors);
                        }
                    }
                }
            });


        });
        $('#month-hit').on('click', function (e) {
            $("canvas#myChart").remove();
            $("div#chart-block").append('<canvas id="myChart" class="w-100" height="300px"></canvas>');
            e.preventDefault();
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/admin-hit-count',
                data: {'time': 'month'},
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        if (data.data.date !== null && data.data.visits !== null) {
                            drawGraph(data.data.date, data.data.visits, data.data.visitors);
                        }
                    }
                }
            });


        });


        function drawGraph(label, data1, data2) {
            //data1 = total count, data2 = unique count
            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: label,
                    datasets: [{
                        label: 'Visits',
                        data: data1,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            // 'rgba(255, 99, 132, 1)',
                            // 'rgba(255, 206, 86, 1)',
                            // 'rgba(75, 192, 192, 1)',
                            // 'rgba(153, 102, 255, 1)',
                            // 'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 2
                    }, {
                        label: 'Visitors',
                        data: data2,
                        backgroundColor: [
                            'rgba(75, 192, 192, 1)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            // 'rgba(54, 162, 235, 1)',
                            // 'rgba(255, 99, 132, 1)',
                            // 'rgba(255, 206, 86, 1)',
                            // 'rgba(153, 102, 255, 1)',
                            // 'rgba(255, 159, 64, 1)'
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

        function drawPieChart(ctx, labels, data) {
            let myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ["Green", "Blue", "Gray", "Purple"],
                    datasets: [{
                        backgroundColor: [
                            "#2ecc71",
                            "#3498db",
                            "#95a5a6",
                            "#9b59b6",
                            "#f1c40f",
                            "#e74c3c",
                            "#34495e"
                        ],
                        data: [12, 19, 3, 17]
                    }]
                }
            });
        }


    });
})
(jQuery);
