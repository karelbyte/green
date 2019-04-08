(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/products_offereds"],{

/***/ "./resources/js/core.js":
/*!******************************!*\
  !*** ./resources/js/core.js ***!
  \******************************/
/*! exports provided: core */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "core", function() { return core; });
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var core = {
  data: function data() {
    return {
      delobj: '',
      keyObjDelete: '',
      propertyShowDelObj: '',
      patchDelete: '',
      title: '',
      labeledit: '',
      labelnew: '',
      lists: [],
      spin: false,
      act: 'post',
      fieldtype: 'text',
      pager_list: {
        page: 1,
        recordpage: 10,
        totalpage: 0
      }
    };
  },
  directives: {
    focus: {
      inserted: function inserted(el) {
        el.focus();
      }
    },
    numericonly: {
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
    }
  },
  watch: {
    'filters_list.value': function filters_listValue() {
      this.getlist();
    }
  },
  mounted: function mounted() {
    this.getlist();
  },
  methods: {
    setfield: function setfield(f) {
      this.filters_list.value = '';
      this.filters_list.descrip = f.name;
      this.filters_list.field = f.field;
      if (f.type === 'select') this.filters_list.options = f.options;
      this.fieldtype = f.type;
    },
    add: function add() {
      this.item = _objectSpread({}, this.itemDefault);
      this.act = 'post';
      this.title = this.labelnew;
      this.onviews('new');
    },
    edit: function edit(it) {
      this.item = _objectSpread({}, it);
      this.act = 'put';
      this.title = this.labeledit;
      this.onviews('new');
    },
    delitem: function delitem() {
      var _this = this;

      this.spin = true;
      axios({
        method: 'delete',
        url: urldomine + this.patchDelete + this.item[this.keyObjDelete]
      }).then(function (r) {
        _this.spin = false;
        $('#modaldelete').modal('hide');

        _this.$toasted.success(r.data);

        _this.getlist();
      })["catch"](function (e) {
        _this.spin = false;

        _this.$toasted.error(e.response.data);
      });
    },
    showdelete: function showdelete(it) {
      this.item = _objectSpread({}, it);
      this.delobj = it[this.propertyShowDelObj];
      $('#modaldelete').modal('show');
    },
    close: function close() {
      this.getlist();
      this.onviews('list');
    },
    onviews: function onviews(pro) {
      for (var property in this.views) {
        this.views[property] = property === pro;
      }
    }
  }
};

/***/ }),

/***/ "./resources/js/products_offereds.js":
/*!*******************************************!*\
  !*** ./resources/js/products_offereds.js ***!
  \*******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./core */ "./resources/js/core.js");
/* harmony import */ var _tools__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./tools */ "./resources/js/tools.js");
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



new Vue({
  mixins: [_core__WEBPACK_IMPORTED_MODULE_0__["core"]],
  el: '#app',
  data: function data() {
    return {
      views: {
        list: true,
        "new": false
      },
      item: {
        id: 0,
        name: '',
        details: []
      },
      itemDefault: {
        id: 0,
        name: '',
        details: []
      },
      det: {
        id: 0,
        name: '',
        init: 1,
        end: ''
      },
      detDedault: {
        id: 0,
        name: '',
        init: 1,
        end: ''
      },
      repassword: '',
      listfield: [{
        name: 'Codigo',
        type: 'text',
        field: 'products_offereds.name'
      }],
      filters_list: {
        descrip: 'Descripción',
        field: 'products_offereds.name',
        value: ''
      },
      orders_list: {
        field: 'products_offereds.name',
        type: 'asc'
      }
    };
  },
  mounted: function mounted() {
    this.propertyShowDelObj = 'name';
    this.labeledit = 'Actualizar producto';
    this.labelnew = 'Añadir producto';
    this.patchDelete = 'api/productsoffereds/';
    this.keyObjDelete = 'id';
  },
  methods: {
    getlist: function getlist(pFil, pOrder, pPager) {
      var _this = this;

      if (pFil !== undefined) {
        this.filters = pFil;
      }

      if (pOrder !== undefined) {
        this.orders = pOrder;
      }

      if (pPager !== undefined) {
        this.pager = pPager;
      }

      this.spin = true;
      axios({
        method: 'post',
        url: urldomine + 'api/productsoffereds/list',
        data: {
          start: this.pager_list.page - 1,
          take: this.pager_list.recordpage,
          filters: this.filters_list,
          orders: this.orders_list
        }
      }).then(function (res) {
        _this.spin = false;
        _this.lists = res.data.list;
        _this.pager_list.totalpage = Math.ceil(res.data.total / _this.pager_list.recordpage);
      })["catch"](function (e) {
        _this.spin = false;

        _this.$toasted.error(e.response.data);
      });
    },
    save: function save() {
      var _this2 = this;

      this.spin = true;
      axios({
        method: this.act,
        url: urldomine + 'api/productsoffereds' + (this.act === 'post' ? '' : '/' + this.item.id),
        data: this.item
      }).then(function (response) {
        _this2.spin = false;

        _this2.$toasted.success(response.data);

        _this2.getlist();

        _this2.onviews('list');
      })["catch"](function (e) {
        _this2.spin = false;

        _this2.$toasted.error(e.response.data);
      });
    },
    edit: function edit(it) {
      this.item = _objectSpread({}, it);
      this.act = 'put';
      this.title = this.labeledit;
      this.onviews('new');
    },
    delDetail: function delDetail(id) {
      this.item.details = this.item.details.filter(function (it) {
        return it.id !== id;
      });
    },
    addNew: function addNew() {
      this.det.id = Object(_tools__WEBPACK_IMPORTED_MODULE_1__["generateId"])(9);
      this.item.details.push(_objectSpread({}, this.det));
      $('#add_det').modal('hide');
    },
    pass: function pass() {
      var name = this.item.code !== '';
      var list = this.item.details.length > 0;
      return name && list;
    },
    showAddDet: function showAddDet() {
      this.det = _objectSpread({}, this.detDedault);
      $('#add_det').modal('show');
    },
    passNew: function passNew() {
      var name = this.det.name !== '';
      var init = this.det.init !== '' && this.det.init > 0;
      var end = this.det.end !== '' && this.det.end > 0;
      return name && init && end;
    }
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

/***/ 10:
/*!*************************************************!*\
  !*** multi ./resources/js/products_offereds.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/products_offereds.js */"./resources/js/products_offereds.js");


/***/ })

},[[10,"/js/app/manifest"]]]);