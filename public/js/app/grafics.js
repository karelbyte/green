(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/grafics"],{

/***/ "./resources/js/grafics.js":
/*!*********************************!*\
  !*** ./resources/js/grafics.js ***!
  \*********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _tools__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./tools */ "./resources/js/tools.js");

Vue.use(VueHighcharts);
new Vue({
  el: '#app',
  data: function data() {
    return {
      spin: false,
      meses: [{
        id: 0,
        month: 'Enero'
      }, {
        id: 1,
        month: 'Febrero'
      }, {
        id: 2,
        month: 'Marzo'
      }, {
        id: 3,
        month: 'Abril'
      }, {
        id: 4,
        month: 'Mayo'
      }, {
        id: 5,
        month: 'Junio'
      }, {
        id: 6,
        month: 'Julio'
      }, {
        id: 7,
        month: 'Agosto'
      }, {
        id: 8,
        month: 'Septiembre'
      }, {
        id: 9,
        month: 'Octubre'
      }, {
        id: 10,
        month: 'Noviembre'
      }, {
        id: 11,
        month: 'Diciembre'
      }],
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
                color: Highcharts.theme && Highcharts.theme.contrastTextColor || 'black'
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
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
    };
  },
  methods: {
    dateToEs: _tools__WEBPACK_IMPORTED_MODULE_0__["dateEs"],
    getMonth: function getMonth() {
      return this.meses.find(function (it) {
        return it.id === new Date().getMonth();
      }).month;
    }
  },
  mounted: function mounted() {
    var _this = this;

    axios.get(urldomine + 'api/grafics/data_month').then(function (r) {
      //CLIENTES ATENDIDOS MES
      _this.client_care_month = r.data.client_care_month;
      _this.client_care_month_last = r.data.client_care_month_last; // VENTAS EN EL MES

      _this.sale_month = r.data.sale_month;
      _this.sale_month_last = r.data.sale_month_last; // VENTAS EN EL MES

      _this.quote_month = r.data.quote_month;
      _this.quote_month_last = r.data.quote_month_last; // MANTENIMIENTOS EN EL MES

      _this.maintenance_month = r.data.maintenance_month;
      _this.maintenance_month_last = r.data.maintenance_month_last; // MOTO VENTA DEL MES

      _this.amout_sale_month = r.data.amout_sale_month;
      _this.amout_sale_month_last = r.data.amout_sale_month_last;
    });
  }
});

/***/ }),

/***/ "./resources/js/tools.js":
/*!*******************************!*\
  !*** ./resources/js/tools.js ***!
  \*******************************/
/*! exports provided: options, rangoutil, dateEs, generateId */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "options", function() { return options; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "rangoutil", function() { return rangoutil; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "dateEs", function() { return dateEs; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "generateId", function() { return generateId; });
window.urldomine = document.location.origin + '/';
var options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-bottom-center",
  "preventDuplicates": false,
  "showDuration": "300",
  "hideDuration": "300",
  "timeOut": "2000",
  "extendedTimeOut": "500",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
function rangoutil(totalpage, currentpage) {
  var star, end, total;
  total = totalpage !== null ? parseInt(totalpage) : 0;

  if (total <= 5) {
    star = 1;
    end = total + 1;
  } else {
    if (currentpage <= 2) {
      star = 1;
      end = 6;
    } else if (currentpage + 2 >= total) {
      star = total - 5;
      end = total + 1;
    } else {
      star = currentpage - 2;
      end = currentpage + 3;
    }
  }

  var range = [];

  for (var i = star; i < end; i++) {
    range.push(i);
  }

  return range;
}

function keyvalid(e) {
  var key = e.key;
  var permitidos = ['.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'Backspace', 'ArrowLeft', 'ArrowLeft', 'Delete', 'Tab'];
  if (!permitidos.includes(key)) e.preventDefault();
}

function fixdate(dt) {
  dt = new Date(dt);
  var m = dt.getMonth() < 9 ? '0' + (dt.getMonth() + 1) : dt.getMonth() + 1;
  var d = dt.getDate() < 10 ? '0' + dt.getDate() : dt.getDate();
  return d + '/' + m + '/' + dt.getFullYear();
}

function dateEs(dt) {
  return new Date(dt.replace(/-/g, '/')).toLocaleDateString();
}

function dec2hex(dec) {
  return ('0' + dec.toString(16)).substr(-2);
}

function generateId(len) {
  var arr = new Uint8Array((len || 40) / 2);
  window.crypto.getRandomValues(arr);
  return Array.from(arr, dec2hex).join('');
}
Vue.directive('focus', {
  inserted: function inserted(el) {
    el.focus();
  }
});
Vue.directive('numeric-only', {
  bind: function bind(el) {
    el.addEventListener('keydown', function (e) {
      if ([46, 8, 9, 27, 13, 110, 190].indexOf(e.keyCode) !== -1 || // Allow: Ctrl+A
      e.keyCode === 65 && e.ctrlKey === true || // Allow: Ctrl+C
      e.keyCode === 67 && e.ctrlKey === true || // Allow: Ctrl+X
      e.keyCode === 88 && e.ctrlKey === true || // Allow: home, end, left, right
      e.keyCode >= 35 && e.keyCode <= 39) {
        // let it happen, don't do anything
        return;
      } // Ensure that it is a number and stop the keypress


      if ((e.shiftKey || e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
      }
    });
  }
});

/***/ }),

/***/ 22:
/*!***************************************!*\
  !*** multi ./resources/js/grafics.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/grafics.js */"./resources/js/grafics.js");


/***/ })

},[[22,"/js/app/manifest"]]]);