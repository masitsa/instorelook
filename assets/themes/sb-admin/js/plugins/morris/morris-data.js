$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2010 Q1',
            Approved: 2666,
            Pending: null,
            Disapproved: 2647
        }, {
            period: '2010 Q2',
            Approved: 2778,
            Pending: 2294,
            Disapproved: 2441
        }, {
            period: '2010 Q3',
            Approved: 4912,
            Pending: 1969,
            Disapproved: 2501
        }, {
            period: '2010 Q4',
            Approved: 3767,
            Pending: 3597,
            Disapproved: 5689
        }, {
            period: '2011 Q1',
            Approved: 6810,
            Pending: 1914,
            Disapproved: 2293
        }, {
            period: '2011 Q2',
            Approved: 5670,
            Pending: 4293,
            Disapproved: 1881
        }, {
            period: '2011 Q3',
            Approved: 4820,
            Pending: 3795,
            Disapproved: 1588
        }, {
            period: '2011 Q4',
            Approved: 15073,
            Pending: 5967,
            Disapproved: 5175
        }, {
            period: '2012 Q1',
            Approved: 10687,
            Pending: 4460,
            Disapproved: 2028
        }, {
            period: '2012 Q2',
            Approved: 8432,
            Pending: 5713,
            Disapproved: 1791
        }],
        xkey: 'period',
        ykeys: ['Approved', 'Pending', 'Disapproved'],
        labels: ['Approved', 'Pending', 'Disapproved'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Flight Type 1",
            value: 12
        }, {
            label: "Flight Type 2",
            value: 30
        }, {
            label: "Flight Type 3",
            value: 20
        }],
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Received', 'Pending'],
        hideHover: 'auto',
        resize: true
    });

});
