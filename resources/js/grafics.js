import {dateEs} from './tools';
Vue.use(VueHighcharts);
new Vue({
    el: '#app',
    data () {
        return {
            spin: false,
            meses: [{id:0, month: 'Enero'}, {id:1, month: 'Febrero'}, {id:2, month: 'Marzo'}, {id:3, month: 'Abril'},
                {id:4, month: 'Mayo'},  {id:5, month: 'Junio'},  {id:6, month: 'Julio'},  {id:7, month: 'Agosto'},
                {id:8, month: 'Septiembre'}, {id:9, month: 'Octubre'},  {id:10, month: 'Noviembre'},  {id:11, month: 'Diciembre'}],
            client_care_month: 0,
            client_care_month_last: 0,
            sale_month: 0,
            sale_month_last: 0,
            quote_month: 0,
            quote_month_last: 0,
            maintenance_month: 0,
            maintenance_month_last: 0,
            amout_sale_month: 0,
            amout_sale_month_last: 0,
            pie: {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'CLIENTES POR PROCESO DEL CAG'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f}',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: [{
                        name: 'VISITA A DOMICIO',
                        y: 10,
                        sliced: true,
                        selected: true
                    }, {
                        name: 'COTIZACION A DISTANCIA',
                        y: 20
                    }, {
                        name: 'ENVIO DE INFORMACION',
                        y: 20
                    }, {
                        name: 'EN ESPERA DE CONFIRMACION',
                        y: 10
                    }, {
                        name: 'COTIZANDO',
                        y: 5
                    }, {
                        name: 'EN PROCESO DE EJECUCION',
                        y: 10
                    }, {
                        name: 'VENTA DIRECTA',
                        y: 10
                    }, {
                        name: 'MANTENIMIENTO',
                        y: 5
                    }, {
                        name: 'RECOMENDACIONES',
                        y: 10
                    }]
                }]
            },
            options: {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Monthly Average Rainfall'
                },
                subtitle: {
                    text: 'Source: WorldClimate.com'
                },
                xAxis: {
                    categories: [
                        'Jan',
                        'Feb',
                        'Mar',
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep',
                        'Oct',
                        'Nov',
                        'Dec'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Rainfall (mm)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Tokyo',
                    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

                }, {
                    name: 'New York',
                    data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

                }, {
                    name: 'London',
                    data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

                }, {
                    name: 'Berlin',
                    data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

                }]
            }
        }
    },
    methods: {
        dateToEs : dateEs,
        getMonth () {
            return this.meses.find(it => it.id === new Date().getMonth()).month
        }
    },
    mounted () {
      axios.get(urldomine + 'api/grafics/data_month').then(r => {
          //CLIENTES ATENDIDOS MES
          this.client_care_month = r.data.client_care_month;
          this.client_care_month_last = r.data.client_care_month_last;
          // VENTAS EN EL MES
          this.sale_month = r.data.sale_month;
          this.sale_month_last = r.data.sale_month_last;
          // VENTAS EN EL MES
          this.quote_month = r.data.quote_month;
          this.quote_month_last = r.data.quote_month_last;
          // MANTENIMIENTOS EN EL MES
          this.maintenance_month = r.data.maintenance_month;
          this.maintenance_month_last = r.data.maintenance_month_last;

          // MOTO VENTA DEL MES
          this.amout_sale_month = r.data.amout_sale_month;
          this.amout_sale_month_last = r.data.amout_sale_month_last;

      });
    }

});
