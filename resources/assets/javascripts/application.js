$("#registerVetName").keyup(function(e){
    var q = $("#registerVetName").val().replace(/\s+/g, '');
    if(q.length < 3) return;
    $("#results").empty();
    $("#results").addClass('loading');

    $.getJSON("/user/dashboard/vet-search",
        {
            term: q,
        },
        function(data) {
            $("#results").removeClass('loading');
            if (data.length) {
                $("#results").append("<p>Results for <b>" + q + "</b></p>");
                $.each(data, function (i, item) {
                    $("#results").append("<div class='row vetname small-top-buffer' data-text='" + item.company_name + "' ><div class='col-xs-3 small-padding' ><img src='/images/vet-image.png' class='img-responsive img-circle' width='100%' /></div><div class='col-xs-6' ><h4 class='top-none bottom-none'>" + item.company_name + "</h4><small class='top-none'>" + item.city + "</small></div><div class='col-xs-3 small-padding' ><a href='/user/register/vet/add-vet/" + item.id + "' ><button class='btn-block btn btn-default btn-md' >Add</button></a></div></div>");
                });
            }
            else {
                $("#results").append("<p>No results found for <b>" + q + "</b></p>");
            }
        }
    );

});


$("#searchVetLocation").keyup(function(e){
    var location = $("#searchVetLocation").val().replace(/\s+/g, '');
    if(location.length < 3) return;
    $("#results").addClass('loading');

    geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'address': location }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            $.getJSON("/user/dashboard/vet-search-location",
                {
                    lat: results[0].geometry.location.lat(),
                    lng: results[0].geometry.location.lng(),

                },
                function(data) {
                    $("#results").empty();
                    $("#results").removeClass('loading');
                    if (data.length) {
                        $("#results").append("<p>Results for <b>" + location + "</b></p>");
                        $.each(data, function (i, item) {
                            $("#results").append("<div class='row vetname small-top-buffer' data-text='" + item.company_name + "' ><div class='col-xs-3 small-padding' ><img src='/images/vet-image.png' class='img-responsive img-circle' width='100%' /></div><div class='col-xs-6' ><h4 class='top-none bottom-none'>" + item.company_name + "</h4><small class='top-none'>" + item.city + "</small></div><div class='col-xs-3 small-padding' ><a href='/user/dashboard/add-vet/" + item.id + "' ><button class='btn-block btn btn-default btn-md' >Add</button></a></div></div>");
                        });
                    }
                    else {
                        $("#results").append("<p>No results found for <b>" + location + "</b></p>");
                    }
                }
            );
        }
    });

});


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

$( document ).ready(function() {});