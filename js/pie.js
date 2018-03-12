var x1 = parseInt(document.getElementById('x1').innerText);
var x2 = parseInt(document.getElementById('x2').innerText);
var x3 = parseInt(document.getElementById('x3').innerText);
var x4 = parseInt(document.getElementById('x4').innerText);
var x5 = parseInt(document.getElementById('x5').innerText);
var x6 = parseInt(document.getElementById('x6').innerText);
var x7 = parseInt(document.getElementById('x7').innerText);
Highcharts.chart('container', {
    
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Info Ideas per Departments overall %'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Departments',
        colorByPoint: true,
        data: [{
            name: 'IT Department',
            y: x1
        }, {
            name: 'Computing & Information Systems',
            y: x2,
            sliced: true,
            selected: true
        }, {
            name: 'Engineering & Science',
            y: x3
        }, {
            name: 'History, Politics & Social Sciences',
            y: x4
        }, {
            name: 'Literature, Language & Theatre',
            y: x5
        },{
            name: 'Psychology, Social Work and Counselling',
            y: x6
        }, {
            name: 'International Business & Economics',
            y: x7
        }]
    }]
});
