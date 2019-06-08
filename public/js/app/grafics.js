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
                color: Highcharts.theme && Highcharts.theme.contrastTextColor || 'black'
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
          categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
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
      _this.amout_sale_month_last = r.data.amout_sale_month_last; // GRAFICA DE PIE CAG ESTADOS

      _this.pie.subtitle.text = 'CANTIDAD EN EL MES ' + r.data.pie_cag_status.cant_cag;

      _this.pie.series.push({
        name: 'Brands',
        colorByPoint: true,
        data: r.data.pie_cag_status.data
      });

      _this.sale_for_month.series.push({
        name: 'Venta',
        color: "#257f4d",
        data: r.data.sales_for_year
      });
    });
  }
});

/***/ }),

/***/ "./resources/js/tools.js":
/*!*******************************!*\
  !*** ./resources/js/tools.js ***!
  \*******************************/
/*! exports provided: options, rangoutil, dateEs, generateId, convertTime12to24 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "options", function() { return options; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "rangoutil", function() { return rangoutil; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "dateEs", function() { return dateEs; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "generateId", function() { return generateId; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "convertTime12to24", function() { return convertTime12to24; });
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

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
function convertTime12to24(time12h) {
  var _time12h$split = time12h.split(' '),
      _time12h$split2 = _slicedToArray(_time12h$split, 2),
      time = _time12h$split2[0],
      modifier = _time12h$split2[1];

  var _time$split = time.split(':'),
      _time$split2 = _slicedToArray(_time$split, 2),
      hours = _time$split2[0],
      minutes = _time$split2[1];

  if (hours === '12') {
    hours = '00';
  }

  if (modifier === 'PM') {
    hours = parseInt(hours, 10) + 12;
  }

  return "".concat(hours, ":").concat(minutes);
}

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