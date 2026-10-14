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

    let elements = document.querySelectorAll('.t3gamingrecort-chart-record');

    if (elements.length) {

        console.log(window.location.href, elements.length);

        fetch(window.location.href, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
            .then(response => response.json())
            .then(data => console.log(data));

        elements.forEach(e => {
            let chart_record = Highcharts.chart(e, Object.assign({}, settings.full, settings.record));
        });
    }
};