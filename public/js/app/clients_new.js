(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/clients_new"],{

/***/ "./resources/js/clients_new.js":
/*!*************************************!*\
  !*** ./resources/js/clients_new.js ***!
  \*************************************/
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
      act: 'post',
      user_id_auth: 0
    };
  },
  mounted: function mounted() {
    this.user_id_auth = parseInt($('#user_id_auth').val());
    this.add();
  },
  methods: {
    save: function save() {
      var _this = this;

      this.spin = true;
      this.item.register_to = this.user_id_auth;
      axios({
        method: this.act,
        url: urldomine + 'api/clients' + (this.act === 'post' ? '' : '/' + this.item.id),
        data: this.item
      }).then(function (response) {
        _this.spin = false;

        _this.$toasted.success(response.data);

        _this.add();
      })["catch"](function (e) {
        _this.spin = false;

        _this.$toasted.error(e.response.data);
      });
    },
    add: function add() {
      var _this2 = this;

      axios.get(urldomine + 'api/clients/get/id').then(function (r) {
        _this2.item = _objectSpread({}, _this2.itemDefault);
        _this2.act = 'post';
        _this2.item.code = r.data;
        _this2.title = _this2.labelnew;
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

/***/ 14:
/*!*******************************************!*\
  !*** multi ./resources/js/clients_new.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/clients_new.js */"./resources/js/clients_new.js");


/***/ })

},[[14,"/js/app/manifest"]]]);