(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/roles"],{

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
        recordpage: 39,
        totalpage: 0
      },
      user_id_auth: 0,
      off: false,
      filters_list_aux: {
        descrip: '',
        field: '',
        type: '',
        value: ''
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
    this.user_id_auth = parseInt($('#user_id_auth').val());

    if (!this.off) {
      this.getlist();
    }
  },
  methods: {
    setfield: function setfield(f) {
      this.filters_list = _objectSpread({}, this.filters_list_aux);
      this.filters_list.value = '';
      this.filters_list.descrip = f.name;
      this.filters_list.field = f.field;
      this.filters_list.type = f.type;
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

/***/ "./resources/js/roles.js":
/*!*******************************!*\
  !*** ./resources/js/roles.js ***!
  \*******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./core */ "./resources/js/core.js");
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


var roles = new Vue({
  el: '#app',
  mixins: [_core__WEBPACK_IMPORTED_MODULE_0__["core"]],
  data: function data() {
    return {
      item: {
        id: 0,
        name: '',
        permissions: []
      },
      itemDefault: {
        id: 0,
        name: '',
        permissions: []
      },
      filters_list: {
        field: 'roles.name',
        value: ''
      },
      orders_list: {
        field: 'name',
        type: 'desc'
      },
      views: {
        list: true,
        "new": false
      },
      all: false,
      grants: []
    };
  },
  mounted: function mounted() {
    this.propertyShowDelObj = 'name';
    this.labeledit = 'Modificar rol';
    this.labelnew = 'Añadir rol';
    this.patchDelete = 'api/roles/';
    this.getlist();
  },
  methods: {
    getlist: function getlist(pFil, pOrder, pPager) {
      var _this = this;

      if (pFil !== undefined) {
        this.filters_list = pFil;
      }

      if (pOrder !== undefined) {
        this.orders_list = pOrder;
      }

      if (pPager !== undefined) {
        this.pager_list = pPager;
      }

      this.spin = true;
      axios({
        method: 'post',
        url: urldomine + 'api/roles/list',
        data: {
          start: this.pager_list.page - 1,
          take: this.pager_list.recordpage,
          filters: this.filters_list,
          orders: this.orders_list
        }
      }).then(function (response) {
        _this.spin = false;
        _this.lists = response.data.list;
        _this.modules = response.data.permisos;
        _this.pager_list.totalpage = Math.ceil(response.data.total / _this.pager_list.recordpage);
      })["catch"](function (e) {
        _this.spin = false;

        _this.$toasted.error(e.response.data);
      });
    },
    add: function add() {
      this.item = _objectSpread({}, this.itemDefault);
      this.act = 'post';
      this.title = this.labelnew;
      this.grants = [];
      this.all = false;
      this.onviews('new');
    },
    edit: function edit(it) {
      this.item = _objectSpread({}, it);
      this.act = 'put';
      this.title = 'Actualizar rol: ' + this.item.name;
      this.grants = this.item.permissions.map(function (it) {
        return it.name;
      });
      this.onviews('new');
    },
    chekset: function chekset(rol) {
      if (!this.grants.includes(rol)) {
        this.grants = this.grants.filter(function (it) {
          return it.indexOf(rol) === -1;
        });
      }
    },
    checkall: function checkall() {
      this.grants = this.all ? this.modules : [];
    },
    save: function save() {
      var _this2 = this;

      var datos = {
        'rol': this.item.name,
        'permission': this.grants
      };

      if (datos.permission.length > 0) {
        this.spin = true;
        axios({
          method: this.act,
          url: urldomine + 'api/roles' + (this.act === 'post' ? '' : '/' + this.item.id),
          data: datos
        }).then(function (response) {
          _this2.spin = false;

          _this2.$toasted.success(response.data);

          _this2.getlist();

          _this2.onviews('list');
        })["catch"](function (e) {
          _this2.spin = false;

          _this2.$toasted.error(e.response.data);
        });
      } else {
        this.$toasted.error('Tiene que selecionar algun modulo con sus permisos!');
      }
    },
    delitem: function delitem() {
      var _this3 = this;

      this.spin = true;
      axios({
        method: 'delete',
        url: urldomine + 'api/roles/' + this.item.id
      }).then(function (response) {
        _this3.spin = false;
        $('#modaldelete').modal('hide');

        _this3.$toasted.success(response.data);

        _this3.getlist();
      })["catch"](function (e) {
        _this3.spin = false;

        _this3.$toasted.error(e.response.data);
      });
    },
    pass: function pass() {
      return this.item.name !== '' && this.grants.length > 0;
    }
  }
});

/***/ }),

/***/ 4:
/*!*************************************!*\
  !*** multi ./resources/js/roles.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/roles.js */"./resources/js/roles.js");


/***/ })

},[[4,"/js/app/manifest"]]]);