(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/providers_new"],{

/***/ "./resources/js/providers_new.js":
/*!***************************************!*\
  !*** ./resources/js/providers_new.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

new Vue({
  el: '#app',
  data: function data() {
    return {
      spin: false,
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
      act: 'post'
    };
  },
  methods: {
    save: function save() {
      var _this = this;

      this.spin = true;
      axios({
        method: this.act,
        url: urldomine + 'api/providers' + (this.act === 'post' ? '' : '/' + this.item.id),
        data: this.item
      }).then(function (response) {
        _this.spin = false;

        _this.$toasted.success(response.data);

        _this.item = _objectSpread({}, _this.itemDefault);
      })["catch"](function (e) {
        _this.spin = false;

        _this.$toasted.error(e.response.data);
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

/***/ 13:
/*!*********************************************!*\
  !*** multi ./resources/js/providers_new.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/providers_new.js */"./resources/js/providers_new.js");


/***/ })

},[[13,"/js/app/manifest"]]]);