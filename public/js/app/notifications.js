(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/notifications"],{

/***/ "./resources/js/notifications.js":
/*!***************************************!*\
  !*** ./resources/js/notifications.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _tools__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./tools */ "./resources/js/tools.js");

var notifications = new Vue({
  el: '#app',
  data: function data() {
    return {
      user_id_auth: 0,
      spin: false,
      landscapers: [],
      quoteconfirm: [],
      quotetracing: [],
      sale_note_not_close: [],
      quote_local_close: [],
      sale_note_not_payment: [],
      sale_note_not_delivered: [],
      qualities_send_info: [],
      qualities_send_info_confirm: [],
      visit_home_end: [],
      maintenances: [],
      not: 0
    };
  },
  methods: {
    dateToEs: _tools__WEBPACK_IMPORTED_MODULE_0__["dateEs"],
    gotoUrl: function gotoUrl(id, type) {
      var patch = '';

      switch (type) {
        case 1:
          // COTIZACION A DOMICIOLIO
          patch = document.location.origin + '/cotizaciones/' + id;
          break;

        case 2:
          // NOTAS DE VENTA
          patch = document.location.origin + '/notas-de-ventas/' + id;
          break;

        case 3:
          // RECOMENDACIONES
          patch = document.location.origin + '/calidad/' + id;
          break;

        case 4:
          // MANTENIMIENTOS
          patch = document.location.origin + '/mantenimientos/' + id;
          break;

        default:
      }

      return patch;
    }
  },
  mounted: function mounted() {
    var _this = this;

    this.user_id_auth = parseInt($('#user_id_auth').val());
    axios.post(urldomine + 'api/notifications/today', {
      user_id_auth: this.user_id_auth
    }).then(function (r) {
      _this.landscapers = r.data.landscapers;
      _this.quoteconfirm = r.data.quoteconfirm;
      _this.quotetracing = r.data.quotetracing;
      _this.sale_note_not_close = r.data.sale_note_not_close;
      _this.quote_local_close = r.data.quote_local_close;
      _this.sale_note_not_payment = r.data.sale_note_not_payment;
      _this.sale_note_not_delivered = r.data.sale_note_not_delivered;
      _this.qualities_send_info = r.data.qualities_send_info;
      _this.qualities_send_info_confirm = r.data.qualities_send_info_confirm;
      _this.visit_home_end = r.data.visit_home_end;
      _this.maintenances = r.data.maintenances;
      _this.not = _this.landscapers.length === 0 && _this.quoteconfirm.length === 0 && _this.quotetracing.length === 0 && _this.sale_note_not_close.length === 0 && _this.quote_local_close.length === 0 && _this.sale_note_not_payment.length && _this.sale_note_not_delivered.length === 0 && _this.qualities_send_info.length === 0 && _this.qualities_send_info_confirm.length === 0 && _this.visit_home_end.length === 0 && _this.maintenances.length === 0;
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

/***/ 20:
/*!*********************************************!*\
  !*** multi ./resources/js/notifications.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/notifications.js */"./resources/js/notifications.js");


/***/ })

},[[20,"/js/app/manifest"]]]);