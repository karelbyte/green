(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/core"],{

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

/***/ 1:
/*!************************************!*\
  !*** multi ./resources/js/core.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/core.js */"./resources/js/core.js");


/***/ })

},[[1,"/js/app/manifest"]]]);