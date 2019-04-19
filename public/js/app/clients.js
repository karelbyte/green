(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/clients"],{

/***/ "./resources/js/clients.js":
/*!*********************************!*\
  !*** ./resources/js/clients.js ***!
  \*********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./core */ "./resources/js/core.js");
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
        code: '',
        contact: '',
        email: '',
        movil: '',
        phone: '',
        address: ''
      },
      itemDefault: {
        id: 0,
        name: '',
        code: '',
        contact: '',
        email: '',
        movil: '',
        phone: '',
        address: ''
      },
      repassword: '',
      listfield: [{
        name: 'Nombre',
        type: 'text',
        field: 'clients.name'
      }, {
        name: 'Codigo',
        type: 'text',
        field: 'clients.code'
      }],
      filters_list: {
        descrip: 'Nombre',
        field: 'clients.name',
        value: ''
      },
      orders_list: {
        field: 'clients.name',
        type: 'asc'
      }
    };
  },
  mounted: function mounted() {
    this.propertyShowDelObj = 'name';
    this.labeledit = 'Actualizar cliente';
    this.labelnew = 'Añadir cliente';
    this.patchDelete = 'api/clients/';
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
        url: urldomine + 'api/clients/list',
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
        toastr["error"](e.response.data);
      });
    },
    save: function save() {
      var _this2 = this;

      this.spin = true;
      axios({
        method: this.act,
        url: urldomine + 'api/clients' + (this.act === 'post' ? '' : '/' + this.item.id),
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
    add: function add() {
      var _this3 = this;

      axios.get(urldomine + 'api/clients/get/id').then(function (r) {
        _this3.item = _objectSpread({}, _this3.itemDefault);
        _this3.act = 'post';
        _this3.item.code = r.data;
        _this3.title = _this3.labelnew;

        _this3.onviews('new');
      });
    },
    pass: function pass() {
      var name = this.item.name !== '';
      var contact = this.item.contact !== '';
      var code = this.item.code !== '';
      var email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);
      return name && contact && code && email;
    }
  }
});

/***/ }),

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
      this.item = JSON.parse(JSON.stringify(this.itemDefault));
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

/***/ 15:
/*!***************************************!*\
  !*** multi ./resources/js/clients.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/clients.js */"./resources/js/clients.js");


/***/ })

},[[15,"/js/app/manifest"]]]);