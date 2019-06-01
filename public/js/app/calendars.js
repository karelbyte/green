(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/calendars"],{

/***/ "./resources/js/calendars.js":
/*!***********************************!*\
  !*** ./resources/js/calendars.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

Vue.config.devtools = true;
new Vue({
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
      datas: [],
      act: 'post'
    };
  },
  components: {
    Multiselect: window.VueMultiselect["default"],
    'vue-cal': vuecal
  },
  mounted: function mounted() {
    var _this = this;

    axios.post(urldomine + 'api/calendars/list').then(function (r) {
      _this.datas = r.data.data;
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
        toastr["success"](response.data);
        _this2.item = _objectSpread({}, _this2.itemDefault);
        _this2.value = '';
      })["catch"](function (e) {
        _this2.spin = false;
        toastr["error"](e.response.data);
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

/***/ 2:
/*!*****************************************!*\
  !*** multi ./resources/js/calendars.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/calendars.js */"./resources/js/calendars.js");


/***/ })

},[[2,"/js/app/manifest"]]]);