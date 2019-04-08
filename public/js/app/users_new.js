(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/users_new"],{

/***/ "./resources/js/users_new.js":
/*!***********************************!*\
  !*** ./resources/js/users_new.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

Vue.config.devtools = true;
var usernew = new Vue({
  el: '#app',
  data: function data() {
    return {
      spin: false,
      item: {
        id: 0,
        name: '',
        password: '',
        email: '',
        rol: '',
        active_id: false,
        position_id: ''
      },
      itemDefault: {
        id: 0,
        name: '',
        password: '',
        email: '',
        rol: '',
        active_id: false,
        position_id: ''
      },
      repassword: '',
      roles: [],
      rol: 0,
      value: '',
      positions: [],
      act: 'post'
    };
  },
  mounted: function mounted() {
    var _this = this;

    axios.get(urldomine + 'api/roles/get').then(function (r) {
      _this.roles = r.data;
    });
    axios.get(urldomine + 'api/users/positions').then(function (r) {
      _this.positions = r.data;
    });
  },
  methods: {
    save: function save() {
      var _this2 = this;

      this.spin = true;
      this.item.rol = this.value;
      var data = {
        'user': this.item
      };
      axios({
        method: this.act,
        url: urldomine + 'api/users' + (this.act === 'post' ? '' : '/' + this.item.uid),
        data: data
      }).then(function (response) {
        _this2.spin = false;

        _this2.$toasted.success(response.data);

        _this2.item = _objectSpread({}, _this2.itemDefault);
        _this2.value = '';
      })["catch"](function (e) {
        _this2.spin = false;

        _this2.$toasted.error(e.response.data);
      });
    },
    pass: function pass() {
      var name = this.item.name !== '';
      var position = this.item.position_id !== '';
      var password = this.item.password === this.repassword && this.item.password !== '';
      var email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);
      var rols = this.value !== '';
      return name && password && email && rols && position;
    }
  }
});

/***/ }),

/***/ 3:
/*!*****************************************!*\
  !*** multi ./resources/js/users_new.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/users_new.js */"./resources/js/users_new.js");


/***/ })

},[[3,"/js/app/manifest"]]]);