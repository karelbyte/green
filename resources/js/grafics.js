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
                subtitle: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: []
            },
            sale_for_month: {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Monto de ventas por mes para el año ' + new Date().getFullYear()
                },
                subtitle: {
                    text: 'Ventas brutas'
                },
                xAxis: {
                    categories: [
                        'Ene',
                        'Feb',
                        'Mar',
                        'Abr',
                        'May',
                        'Jun',
                        'Jul',
                        'Ago',
                        'Sep',
                        'Oct',
                        'Nov',
                        'Dic'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Miles de pesos'
                    }
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: []
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

          // GRAFICA DE PIE CAG ESTADOS
          this.pie.subtitle.text = 'CANTIDAD EN EL MES '  + r.data.pie_cag_status.cant_cag
          this.pie.series.push({
              name: 'Brands',
                  colorByPoint: true,
                  data:  r.data.pie_cag_status.data
          });

          this.sale_for_month.series.push({
              name: 'Venta',
              color:"#257f4d",
              data:  r.data.sales_for_year
          })
      });
    }

});
