import * as Datatables from './Modules/datatables'
import * as Highcharts from './Modules/highcharts'

(function () {
    Datatables.database_init();
    Highcharts.highcharts_init();
})();
