export function highcharts_init() {
    let settings = {
        full: {
            chart: {
                type: 'bar',
                styledMode: true,
            },
            title: {
                text: 'Fruit Consumption'
            },
            xAxis: {
                categories: ['Apples', 'Bananas', 'Oranges']
            },
            yAxis: {
                title: {
                    text: 'Fruit eaten'
                }
            },
            series: [{
                name: 'Jane',
                data: [1, 0, 4]
            }, {
                name: 'John',
                data: [5, 7, 3]
            }]
        },
        basic: {

        },
        record: {

        },
    }

    fetch(window.location.href, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ key: 'value' })
    })
        .then(response => response.json())
        .then(data => console.log(data));



    let elements = document.querySelectorAll('.t3gamingrecort-chart-record');

    elements.forEach(e => {
        let chart_record = Highcharts.chart(e, Object.assign({}, settings.full, settings.record));
    });
};