$("#registerVetName, #searchVetName").keyup(function(e){
    var q = $(this).val().replace(/\s+/g, '');
    if(q.length < 3) return;
    $("#results").empty();
    $("#results").addClass('loading');

    $.getJSON("/user/dashboard/vet-search",
        {
            term: q,
        },
        function(data) {
            respond(data, q);
        }
    );

});


$("#registerVetLocation, #searchVetLocation").keyup(function(e){
    var location = $(this).val().replace(/\s+/g, '');
    if(location.length < 3) return;
    $("#results").empty();
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
                    respond(data, location);
                }
            );
        }
    });
});



function respond(data, key) {
    $("#results").empty();
    $("#results").removeClass('loading');
    if (data['view'] !== undefined ) {
        $("#results").append("<p>Results for <b>" + key + "</b></p>");
        $("#results").append(data.view);
    }
    else {
        $("#results").append("<p>No results found for <b>" + key + "</b></p>");
    }
}


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


//Little hack to active the edit tab on the top of each pet card
$('a.create-pet-tab').click(function(){
    var pet = $(this).attr('href').split('#edit')[1];
    $("a[href='#edit"+pet+"']").parent('li').addClass('active').siblings().removeClass('active');
});