$(function () {
  // set the theme
Highcharts.setOptions({
    chart: {

    },
    title: {
        text: '',

    },
    subtitle: {
        text: '',
    },

    colors: [
        '#c0c0c0'
    ],
    exporting: false,
    yAxis: {
        labels: {
            style: {
                fontSize: '13px',
                fontFamily: 'Arial,sans-serif'
            },
            formatter: function () {
                return '$' + Highcharts.numberFormat(this.value, 2, '.', ",");
            }
        },
        title: {
            text: ''
        }
    },
    xAxis: {
        enabled: true,
        type: 'datetime',
        tickInterval: 30 * 24 * 3600 * 1000
    },
    credits: {
        style: {
            display: 'none'
        }
    },
    tooltip: {
        valueSuffix: '°C'
    },
    legend: {
        enabled: false
    }
});

// default options
var options = {
    chart: {
        margin: 0
    }
};
    $('.report-toggle').click(function(e) {
        setTimeout(function(){
            $('.graph-container').each(function( i, container ) {
                    $container = $(container);
                    var json = $container.data('data');
                    console.log(json);
                    var array = [];

                    $.each(json, function (idx, obj) {
                        if (obj.temperature >= 38.8) {
                            color = "red"
                        }
                        else if (obj.temperature >= 37.8) {
                            color = "orange"
                        }
                        else {
                            color = "#40c8c6"
                        }
                        array.push({y: obj.temperature, x: obj.created_at, color: color});
                    });

                    // create the chart
                    var chart1Options = {
                        chart: {
                            renderTo: container
                        },
                        series: [{
                            data: array,
                        }]
                    };
                    chart1Options = jQuery.extend(true, {}, options, chart1Options);
                    var chart1 = new Highcharts.Chart(chart1Options);
                });
        },400);
    });
    $('.vet-graph-container').each(function( i, container ) {
        $container = $(container);
        var json = $container.data('data');
        console.log(json);
        var array = [];

        $.each(json, function (idx, obj) {
            if (obj.temperature >= 38.8) {
                color = "red"
            }
            else if (obj.temperature >= 37.8) {
                color = "orange"
            }
            else {
                color = "#40c8c6"
            }
            array.push({y: obj.temperature, x: obj.created_at, color: color});
        });

        // create the chart
        var chart1Options = {
            chart: {
                renderTo: container
            },
            series: [{
                data: array,
            }]
        };
        chart1Options = jQuery.extend(true, {}, options, chart1Options);
        var chart1 = new Highcharts.Chart(chart1Options);
    });
});
$( document ).ready(function() {

});