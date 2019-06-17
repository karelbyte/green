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
            // CANTIDADES
            home_visit_cant: 0,
            VERIFICATION_RECEIPT_QUOTATION_CANT: 0,
            STRATEGY_SALE_CANT: 0,
            STRATEGY_SALE_CONFIRM_CANT: 0,
            INQUOTE_CANT: 0,
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
                        point: {},
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
            },
            home_visit_month: {
                chart: {
                    type: 'column'
                },
                title: {
                    style: {
                        fontSize: '14px'
                    },
                    text: 'CAGS EN ESTADO DE VISITA A DOMICILIO'
                },
                subtitle: {
                    text: 'TOTAL DE:'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de Cags'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> del total<br/>'
                },
                series: []
            },
            VERIFICATION_RECEIPT_QUOTATION: {
                chart: {
                    type: 'column'
                },
                title: {
                    style: {
                        fontSize: '14px'
                    },
                    text: 'CAGS EN ESTADO DE VERIFICACION DE RECEPCION DE COTIZACION'
                },
                subtitle: {
                    text: 'TOTAL DE:'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de Cags'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> del total<br/>'
                },
                series: []
            },
            STRATEGY_SALE: {
                chart: {
                    type: 'column'
                },
                title: {
                    style: {
                        fontSize: '14px'
                    },
                    text: 'CAGS EN ESTADO DE ESTRATEGIA DE VENTA'
                },
                subtitle: {
                    text: 'TOTAL DE:'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de Cags'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> del total<br/>'
                },
                series: []
            },
            STRATEGY_SALE_CONFIRM: {
                chart: {
                    type: 'column'
                },
                title: {
                    style: {
                        fontSize: '14px'
                    },
                    text: 'CAGS EN ESTADO CONFIRMANDO ESTRATEGIA DE VENTA'
                },
                subtitle: {
                    text: 'TOTAL DE:'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de Cags'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> del total<br/>'
                },
                series: []
            },
            INQUOTE: {
                chart: {
                    type: 'column'
                },
                title: {
                    style: {
                        fontSize: '14px'
                    },
                    text: 'CAGS EN EN PROCESO DE COTIZACION'
                },
                subtitle: {
                    text: 'TOTAL DE:'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de Cags'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> del total<br/>'
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
              name: 'Cags',
                  colorByPoint: true,
                  data:  r.data.pie_cag_status.data
          });
          this.pie.plotOptions.pie.point = {
              events: {
                  click: function(e) {
                      window.location.href = r.data.url + e.point.status
                  }
              }
          };
          // VENTAS POR MESES
          this.sale_for_month.series.push({
              name: 'Venta',
              color:"#257f4d",
              data:  r.data.sales_for_year,
           });
          // CAGS EN ESTADO DE VISITA
          this.home_visit_cant = r.data.home_visit_month.cant;
          this.home_visit_month.subtitle.text = 'TOTAL DE '  + r.data.home_visit_month.cant;
          this.home_visit_month.series.push({
              name: 'Cags por asesor',
              colorByPoint: true,
              data:  r.data.home_visit_month.data,
          });
          this.home_visit_month.plotOptions.column = {
              events: {
                  click: function(e) {
                    window.location.href = r.data.url + e.point.status + '/' + e.point.id
                  }
              }
          };
          // VERIFICACION RECEPCION DE COTIZACION
          this.VERIFICATION_RECEIPT_QUOTATION_CANT = r.data.VERIFICATION_RECEIPT_QUOTATION.cant;
          this.VERIFICATION_RECEIPT_QUOTATION.subtitle.text = 'TOTAL DE '  + r.data.VERIFICATION_RECEIPT_QUOTATION.cant;
          this.VERIFICATION_RECEIPT_QUOTATION.series.push({
              name: 'Cags por asesor',
              colorByPoint: true,
              data:  r.data.VERIFICATION_RECEIPT_QUOTATION.data,
          });
          this.VERIFICATION_RECEIPT_QUOTATION.plotOptions.column = {
              events: {
                  click: function(e) {
                      window.location.href = r.data.url + e.point.status + '/' + e.point.id
                  }
              }
          };
          // ESTRATEGIA DE VENTA
          this.STRATEGY_SALE_CANT = r.data.STRATEGY_SALE.cant;
          this.STRATEGY_SALE.subtitle.text = 'TOTAL DE '  + r.data.STRATEGY_SALE.cant;
          this.STRATEGY_SALE.series.push({
              name: 'Cags por asesor',
              colorByPoint: true,
              data:  r.data.STRATEGY_SALE.data,
          });
          this.STRATEGY_SALE.plotOptions.column = {
              events: {
                  click: function(e) {
                      window.location.href = r.data.url + e.point.status + '/' + e.point.id
                  }
              }
          };
          // CONFIRMANDO ESTRATEGIA DE VENTA
          this.STRATEGY_SALE_CONFIRM_CANT = r.data.STRATEGY_SALE_CONFIRM.cant;
          this.STRATEGY_SALE_CONFIRM.subtitle.text = 'TOTAL DE '  + r.data.STRATEGY_SALE_CONFIRM.cant;
          this.STRATEGY_SALE_CONFIRM.series.push({
              name: 'Cags por asesor',
              colorByPoint: true,
              data:  r.data.STRATEGY_SALE_CONFIRM.data,
          });
          this.STRATEGY_SALE_CONFIRM.plotOptions.column = {
              events: {
                  click: function(e) {
                      window.location.href = r.data.url + e.point.status + '/' + e.point.id
                  }
              }
          };
          // CONFIRMANDO ESTRATEGIA DE VENTA
          this.INQUOTE_CANT = r.data.INQUOTE.cant;
          this.INQUOTE.subtitle.text = 'TOTAL DE '  + r.data.INQUOTE.cant;
          this.INQUOTE.series.push({
              name: 'Cags por asesor',
              colorByPoint: true,
              data:  r.data.INQUOTE.data,
          });
          this.INQUOTE.plotOptions.column = {
              events: {
                  click: function(e) {
                      window.location.href = r.data.url + e.point.status + '/' + e.point.id
                  }
              }
          };
      });
    }

});
