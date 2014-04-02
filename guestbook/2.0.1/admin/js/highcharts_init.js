$(function () {
    var chart;
    $(document).ready(function() {
    Highcharts.setOptions({
        colors: ['#32353A']
    });
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'column',
                margin: [ 50, 30, 80, 60]
            },
            title: {
                text: 'Visits this month'
            },
            xAxis: {
                categories: [
					'11-03-2012',
                    '12-03-2012',
                    '13-03-2012',
                    '14-03-2012',
                    '15-03-2012',
                    '16-03-2012',
                    '17-03-2012',
                    '18-03-2012',
                    '19-03-2012',
                    '20-03-2012',
                    '21-03-2012',
                    '22-03-2012',
                    '23-03-2012',
                    '24-03-2012',
                    '25-03-2012',
                    '26-03-2012',
                    '27-03-2012',
                    '28-03-2012',
                    '29-03-2012'
                ],
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '9px',
                        fontFamily: 'Tahoma, Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Visits'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        'Visits: '+ Highcharts.numberFormat(this.y, 0);
                }
            },
                series: [{
                name: 'Visits',
                data: [1134, 1029, 1626, 2210, 1019, 1209, 2319, 4118, 1418,
                    1127, 1465, 1375, 1026, 1654, 1423, 1142, 3312, 1126],
                dataLabels: {
                    enabled: false,
                    rotation: 0,
                    color: '#F07E01',
                    align: 'right',
                    x: -3,
                    y: 20,
                    formatter: function() {
                        return this.y;
                    },
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }, 
                pointWidth: 20
            }]
        });
    });
    
});
