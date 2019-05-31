(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app/qualities"],{

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
      },
      user_id_auth: 0
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

/***/ "./resources/js/qualities.js":
/*!***********************************!*\
  !*** ./resources/js/qualities.js ***!
  \***********************************/
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
      formData: 0,
      file: null,
      views: {
        list: true,
        "new": false
      },
      item: {
        id: 0,
        cglobal_id: 0,
        moment: 0,
        confirm: 0,
        url_doc: '',
        client_comment: '',
        status_id: 0
      },
      itemDefault: {
        id: 0,
        cglobal_id: 0,
        moment: 0,
        confirm: 0,
        url_doc: '',
        client_comment: '',
        status_id: 0
      },
      listfield: [{
        name: 'CAG',
        type: 'text',
        field: 'qualities.cglobal_id'
      }, {
        name: 'Cliente',
        type: 'text',
        field: 'clients.name'
      }],
      filters_list: {
        descrip: 'CAG',
        field: 'qualities.cglobal_id',
        value: ''
      },
      orders_list: {
        field: 'qualities.cglobal_id',
        type: 'asc'
      },
      find: 0,
      scrpdf: ''
    };
  },
  mounted: function mounted() {
    this.formData = new FormData();
    this.find = parseInt($('#find').val());

    if (this.find > 0) {
      this.filters_list.value = this.find;
    } else {
      this.getlist();
    }
  },
  methods: {
    dateToEs: _tools__WEBPACK_IMPORTED_MODULE_1__["dateEs"],
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
        url: urldomine + 'api/qualities/list',
        data: {
          start: this.pager_list.page - 1,
          take: this.pager_list.recordpage,
          filters: this.filters_list,
          orders: this.orders_list,
          user_id_auth: this.user_id_auth
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
    },
    commend: function commend(it) {
      this.item = it;
      this.formData.append('client_id', this.item.global.client_id);
      this.formData.append('id', it.id);
      $('#commend').modal('show');
    },
    sendCommend: function sendCommend() {
      var _this4 = this;

      this.spin = true;
      axios.post(urldomine + 'api/qualities/commends', this.formData, {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }).then(function (r) {
        $('#commend').modal('hide');
        axios.get(urldomine + 'api/qualities/details/' + _this4.item.id).then(function (r) {
          _this4.details = r.data;
          _this4.spin = false;
          $('#editItem').modal('hide');
        });

        _this4.$toasted.success(r.data);
      });
    },
    passCommend: function passCommend() {
      return this.file !== null;
    },
    getfile: function getfile(e) {
      var files = e.target.files || e.dataTransfer.files;

      if (!files.length) {
        this.file = null;
      } else {
        this.file = files[0];
        this.formData.append('doc', this.file);
      }
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

/***/ 23:
/*!*****************************************!*\
  !*** multi ./resources/js/qualities.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/green/resources/js/qualities.js */"./resources/js/qualities.js");


/***/ })

},[[23,"/js/app/manifest"]]]);