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
        // platform
        let paltform_dp1 = $('#platform-dp1');
        let paltform_dp2 = $('#platform-dp2');
        paltform_dp1.datepicker({
            dateFormat: "yy-mm-dd",
            allowInputToggle: true,
            defaultDate: -15
        }).datepicker("setDate", -15);
        paltform_dp2.datepicker({
            dateFormat: "yy-mm-dd",
            allowInputToggle: true,
            defaultDate: new Date()

        }).datepicker("setDate", new Date());

        //browser
        let browser_dp1 = $('#browser-dp1');
        let browser_dp2 = $('#browser-dp2');
        browser_dp1.datepicker({
            dateFormat: "yy-mm-dd",
            allowInputToggle: true,
            defaultDate: -15
        }).datepicker("setDate", -15);
        browser_dp2.datepicker({
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

        $.get('/get-referring-sites',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-referring-site').hide();
                $('#referring-site-block').slideDown();
                $('#tbody-referring-site').html(data.view);

                $('#referring-site').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
            }
        );
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
        $.get('/get-top-visitors',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-top-visitors').hide();
                $('#top-visitors-block').slideDown();
                $('#tbody-top-visitors').html(data.view);

                $('#top-visitors').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
            }
        );
        $.get('/get-recent-visitors',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-recent-visitors').hide();
                $('#recent-visitors-block').slideDown();
                $('#tbody-recent-visitors').html(data.view);

                $('#recent-visitors').DataTable({
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

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/top-browser',
                dataType: 'json',
                success: function (data) {

                    if (data.data.status === 200) {
                        if (data.data.browsers !== null) {
                            $('#loader-browser').hide();
                            $('#browser-block').slideDown();

                            drawBrowserPieChart(ctx, data.data.browsers.browsers_name, data.data.browsers.browsers_value, data.data.browsers.total);
                        }
                    }
                }
            });
        }
        if ($('#platformChart').length > 0) {
            let ctx = document.getElementById("platformChart").getContext('2d');
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/top-platform',
                dataType: 'json',
                success: function (data) {

                    if (data.data.status === 200) {
                        if (data.data.platforms !== null) {
                            $('#loader-platform').hide();
                            $('#platform-block').slideDown();

                            // drawGraph(data.data.date, data.data.visits, data.data.visitors);
                            drawPieChart(ctx, data.data.platforms.platform_name, data.data.platforms.platform_value, data.data.platforms.total);

                        }
                    }
                }
            });
        }


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


        //hit stats
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

        //platform

        $('#platform-submit').on('click', function (e) {
            $("canvas#platformChart").remove();
            $("div#platform-chart-block").append('<canvas id="platformChart" class="w-100" height="300px"></canvas>');

            e.preventDefault();
            let dp1_date = paltform_dp1.datepicker('getDate');
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
            let dp2_date = paltform_dp2.datepicker('getDate');
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
            console.log(to, from);
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/top-platform',
                data: {'from': from, 'to': to},
                dataType: 'json',
                success: function (data) {

                    if (data.data.status === 200) {
                        if (data.data.platforms !== null) {
                            $('#loader-platform').hide();
                            $('#platform-block').slideDown();

                            // drawGraph(data.data.date, data.data.visits, data.data.visitors);
                            drawPieChart(document.getElementById("platformChart").getContext('2d'), data.data.platforms.platform_name, data.data.platforms.platform_value, data.data.platforms.total);

                        }
                    }
                }
            });
        });
        $('#year-platform-hit').on('click', function (e) {
            $("canvas#platformChart").remove();
            $("div#platform-chart-block").append('<canvas id="platformChart" class="w-100" height="300px"></canvas>');
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/top-platform',
                data: {'time': 'year'},
                dataType: 'json',
                success: function (data) {

                    if (data.data.status === 200) {
                        if (data.data.platforms !== null) {
                            $('#loader-platform').hide();
                            $('#platform-block').slideDown();

                            // drawGraph(data.data.date, data.data.visits, data.data.visitors);
                            drawPieChart(document.getElementById("platformChart").getContext('2d'), data.data.platforms.platform_name, data.data.platforms.platform_value, data.data.platforms.total);

                        }
                    }
                }
            });
        });
        $('#week-platform-hit').on('click', function (e) {
            $("canvas#platformChart").remove();
            $("div#platform-chart-block").append('<canvas id="platformChart" class="w-100" height="300px"></canvas>');
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/top-platform',
                data: {'time': 'week'},
                dataType: 'json',
                success: function (data) {

                    if (data.data.status === 200) {
                        if (data.data.platforms !== null) {
                            $('#loader-platform').hide();
                            $('#platform-block').slideDown();

                            // drawGraph(data.data.date, data.data.visits, data.data.visitors);
                            drawPieChart(document.getElementById("platformChart").getContext('2d'), data.data.platforms.platform_name, data.data.platforms.platform_value, data.data.platforms.total);

                        }
                    }
                }
            });
        });
        $('#month-platform-hit').on('click', function (e) {
            $("canvas#platformChart").remove();
            $("div#platform-chart-block").append('<canvas id="platformChart" class="w-100" height="300px"></canvas>');
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/top-platform',
                data: {'time': 'month'},
                dataType: 'json',
                success: function (data) {

                    if (data.data.status === 200) {
                        if (data.data.platforms !== null) {
                            $('#loader-platform').hide();
                            $('#platform-block').slideDown();

                            // drawGraph(data.data.date, data.data.visits, data.data.visitors);
                            drawPieChart(document.getElementById("platformChart").getContext('2d'), data.data.platforms.platform_name, data.data.platforms.platform_value, data.data.platforms.total);

                        }
                    }
                }
            });
        });

        //browser

        $('#browser-submit').on('click', function (e) {
            $("canvas#browserChart").remove();
            $("div#browser-chart-block").append('<canvas id="browserChart" class="w-100" height="300px"></canvas>');

            e.preventDefault();
            let dp1_date = browser_dp1.datepicker('getDate');
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
            let dp2_date = browser_dp2.datepicker('getDate');
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
                url: window.location.origin + '/top-browser',
                data: {'from': from, 'to': to},
                dataType: 'json',
                success: function (data) {

                    if (data.data.status === 200) {
                        if (data.data.browsers !== null) {
                            $('#loader-browser').hide();
                            $('#browser-block').slideDown();

                            // drawGraph(data.data.date, data.data.visits, data.data.visitors);
                            drawBrowserPieChart(document.getElementById("browserChart").getContext('2d'), data.data.browsers.browsers_name, data.data.browsers.browsers_value, data.data.browsers.total);
                        }
                    }
                }
            });
        });
        $('#year-browser-hit').on('click', function (e) {
            $("canvas#browserChart").remove();
            $("div#browser-chart-block").append('<canvas id="browserChart" class="w-100" height="300px"></canvas>');

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/top-browser',
                data: {'time': 'year'},
                dataType: 'json',
                success: function (data) {

                    if (data.data.status === 200) {
                        if (data.data.browsers !== null) {
                            $('#loader-browser').hide();
                            $('#browser-block').slideDown();

                            // drawGraph(data.data.date, data.data.visits, data.data.visitors);
                            drawBrowserPieChart(document.getElementById("browserChart").getContext('2d'), data.data.browsers.browsers_name, data.data.browsers.browsers_value, data.data.browsers.total);
                        }
                    }
                }
            });
        });
        $('#week-browser-hit').on('click', function (e) {
            $("canvas#browserChart").remove();
            $("div#browser-chart-block").append('<canvas id="browserChart" class="w-100" height="300px"></canvas>');

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/top-browser',
                data: {'time': 'week'},
                dataType: 'json',
                success: function (data) {

                    if (data.data.status === 200) {
                        if (data.data.browsers !== null) {
                            $('#loader-browser').hide();
                            $('#browser-block').slideDown();

                            // drawGraph(data.data.date, data.data.visits, data.data.visitors);
                            drawBrowserPieChart(document.getElementById("browserChart").getContext('2d'), data.data.browsers.browsers_name, data.data.browsers.browsers_value, data.data.browsers.total);
                        }
                    }
                }
            });
        });
        $('#month-browser-hit').on('click', function (e) {
            $("canvas#browserChart").remove();
            $("div#browser-chart-block").append('<canvas id="browserChart" class="w-100" height="300px"></canvas>');

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/top-browser',
                data: {'time': 'month'},
                dataType: 'json',
                success: function (data) {

                    if (data.data.status === 200) {
                        if (data.data.browsers !== null) {
                            $('#loader-browser').hide();
                            $('#browser-block').slideDown();

                            // drawGraph(data.data.date, data.data.visits, data.data.visitors);
                            drawBrowserPieChart(document.getElementById("browserChart").getContext('2d'), data.data.browsers.browsers_name, data.data.browsers.browsers_value, data.data.browsers.total);
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
                    datasets: [
                        {
                            label: 'Visits',
                            data: data1,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            pointColor: "rgba(54, 162, 235, 1)",
                            pointStrokeColor: "#fff",
                        },

                        {
                            label: 'Visitors',
                            data: data2,
                            backgroundColor: 'rgba(213, 245, 227, 1)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            pointColor: "rgba(75, 192, 192, 1)",
                            pointStrokeColor: "#fff",
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

        function drawPieChart(ctx, labels, data, total) {

            let myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    // labels: ["Green", "Blue", "Gray", "Purple"],
                    labels: labels,
                    datasets: [{
                        backgroundColor: [
                            "#99bbad",
                            "#28b5b5",
                            "#ebd8b7",
                            "#ffaaa7",
                            "#9a8194",
                            "#b0efeb",
                            "#fdbaf8",
                            "#edffa9",
                            "#e2703a",
                            "#9c3d54",
                            "#f21170",
                            "#fa9905",
                            "#1597bb",
                            "#150e56",
                            "#7b113a",
                            "#ffaaa7",
                            "#9a8194",
                            "#b0efeb",
                            "#fdbaf8",

                        ],
                        data: data
                    }],
                },
                // options: {
                //     plugins: {
                //         tooltip: {
                //             callbacks: {
                //
                //                 label: function (context) {
                //                     var label = context.dataset.label || '';
                //
                //                     if (label) {
                //                         label += ': ';
                //                     }
                //                     if (context.parsed.y !== null) {
                //                         label += new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(context.parsed.y);
                //                     }
                //                     return label;
                //                 }
                //             }
                //         }
                //     }
                // }

            });
        }

        function drawBrowserPieChart(ctx, labels, data, total) {

            let myBrowserPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    // labels: ["Green", "Blue", "Gray", "Purple"],
                    labels: labels,
                    datasets: [{
                        backgroundColor: [
                            "#99bbad",
                            "#28b5b5",
                            "#ebd8b7",
                            "#ffaaa7",
                            "#9a8194",
                            "#b0efeb",
                            "#fdbaf8",
                            "#edffa9",
                            "#e2703a",
                            "#9c3d54",
                            "#f21170",
                            "#fa9905",
                            "#1597bb",
                            "#150e56",
                            "#7b113a",
                            "#ffaaa7",
                            "#9a8194",
                            "#b0efeb",
                            "#fdbaf8",

                        ],
                        data: data
                    }],
                },
                // options: {
                //     plugins: {
                //         tooltip: {
                //             callbacks: {
                //
                //                 label: function (context) {
                //                     var label = context.dataset.label || '';
                //
                //                     if (label) {
                //                         label += ': ';
                //                     }
                //                     if (context.parsed.y !== null) {
                //                         label += new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(context.parsed.y);
                //                     }
                //                     return label;
                //                 }
                //             }
                //         }
                //     }
                // }

            });
        }
    });
})
(jQuery);
