(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/company"],{

/***/ "./resources/js/company.js":
/*!*********************************!*\
  !*** ./resources/js/company.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

Vue.config.devtools = true;
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
        address: '',
        email: '',
        www: '',
        rfc: '',
        phone1: '',
        phone2: ''
      },
      itemaux: {
        id: 0,
        name: '',
        address: '',
        email: '',
        www: '',
        rfc: '',
        phone1: '',
        phone2: ''
      },
      act: 'post'
    };
  },
  mounted: function mounted() {
    var _this = this;

    axios.get(urldomine + 'api/ajustes/company/data').then(function (r) {
      _this.item = r.data ? r.data : _this.itemaux;
    });
  },
  methods: {
    save: function save() {
      var _this2 = this;

      this.spin = true;
      axios({
        method: this.act,
        url: urldomine + 'api/ajustes/company' + (this.act === 'post' ? '' : '/' + this.item.id),
        data: this.item
      }).then(function (response) {
        _this2.spin = false;

        _this2.$toasted.success(response.data);
      })["catch"](function (e) {
        _this2.spin = false;

        _this2.$toasted.error(e.response.data);
      });
    },
    pass: function pass() {
      var name = this.item.name !== '';
      var contact = this.item.address !== '';
      var code = this.item.rfc !== '';
      var email = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/i.test(this.item.email);
      return name && contact && code && email;
    }
  }
});

/***/ }),

/***/ 19:
/*!***************************************!*\
  !*** multi ./resources/js/company.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/company.js */"./resources/js/company.js");


/***/ })

},[[19,"/js/app/manifest"]]]);