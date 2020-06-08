/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/filter.js":
/*!********************************!*\
  !*** ./resources/js/filter.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var count_select_checks = new Map();
var config_filter_first = $('meta[name="config-first-param"]').attr('content');
var flag_and = false;
$(document).ready(function () {
  init_count_select_filters();
  printButtonCancelFilters();
  print_selected_filters();
  filter();
  setSlideRange();
});

function filter() {
  var checkboxes = Array.from(document.querySelectorAll("input[type='checkbox']"));
  checkboxes.forEach(function (checkbox, i) {
    checkbox.onchange = function () {
      $.ajax({
        url: window.location.pathname + '/' + this.title,
        type: 'GET',
        data: window.location.search.substr(1),
        name: this.name,
        title: this.title,
        beforeSend: function beforeSend() {
          checkbox.disabled = true;
          count_select_checks.set(this.title, this.name);
        },
        complete: function complete() {
          checkbox.disabled = false;
          window.history.pushState('', "", this.url);
          init_count_select_filters();
          printButtonCancelFilters();
          print_selected_filters();
          setSlideRange();
          filter();
        },
        success: function success(html) {
          $("#common").html(html);
        }
      });
    };
  });
}

function print_selected_filters() {
  if (!$('#filter_selected').length) {
    var filter_content = '<h5 id="filter_selected">Filters were selected</h5>';
    $('#anchor').after(filter_content);
  }

  if (count_select_checks.size) {
    var res = '';
    count_select_checks.forEach(function (item, key, count_select_checks) {
      var icon = '<svg class="bi bi-x-square" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">\n' + '  <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>\n' + '  <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>\n' + '  <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>\n' + '</svg>';

      if (key.length) {
        if (item.length) {
          res = res + '<div class="custom-control custom-checkbox ">' + icon + '<a name=' + key + ' class="selected_filter ml-1" title=' + item + ' href="#">' + item + '</a> </div>';
        } else {
          count_select_checks["delete"](key);
        }
      }
    });
    $('#filter_selected').after(res);
    preparation_selected_filters();
    select_active_filters();
  } else {
    $('#filter_selected').remove();
  }
}

function preparation_selected_filters() {
  var selected_filters = Array.from(document.querySelectorAll("a.selected_filter"));
  selected_filters.forEach(function (selected_filter, i) {
    selected_filter.addEventListener("click", function (event) {
      event.preventDefault();
      var ref = event.target;
      var slug = ref.getAttribute('name');
      var url = window.location.pathname;
      $.ajax({
        url: url.replace('/' + slug, ''),
        type: 'GET',
        data: window.location.search.substr(1),
        beforeSend: function beforeSend() {
          count_select_checks["delete"](slug);
        },
        complete: function complete() {
          window.history.pushState('', "", this.url);
          init_count_select_filters();
          printButtonCancelFilters();
          print_selected_filters();
          setSlideRange();
          filter();
        },
        success: function success(html) {
          $("#common").html(html);
        }
      });
    });
  });
}

function select_active_filters() {
  var checkboxes = Array.from(document.querySelectorAll("input[type='checkbox']"));
  checkboxes.forEach(function (checkbox, i) {
    var title = checkbox.getAttribute('title');

    if (count_select_checks.size) {
      if (count_select_checks.has(title)) {
        checkbox.setAttribute('checked', 'checked');
        checkbox.setAttribute('disabled', 'true');
      }

      var count_filter = checkbox.getAttribute('data-count-filter');

      if (flag_and && title.match(config_filter_first) && count_filter === '0') {
        checkbox.setAttribute('disabled', 'true');
      }
    }
  });
}

function init_count_select_filters() {
  var arr_request = window.location.pathname.split('/');

  for (i = 0; i < arr_request.length; i++) {
    if (arr_request[i].length) {
      var input_check = document.querySelector("input[title='" + arr_request[i] + "'][type='checkbox']");

      if (input_check) {
        count_select_checks.set(arr_request[i], input_check.getAttribute('name'));
      }
    }
  }

  flag_and = false;
  count_select_checks.forEach(function (value, key, map) {
    if (key.match(config_filter_first) === null) {
      flag_and = true;
    }

    ;
  });
}

function setSlideRange() {
  var data_min = Number($('#amount').attr('data-min'));
  var data_max = Number($('#amount').attr('data-max'));
  var data_min_filter = $('#amount').attr('data-min-filter');
  var data_max_filter = $('#amount').attr('data-max-filter');
  var params = new URLSearchParams(window.location.search);
  var min = params.get('min') ? Number(params.get('min')) : Number(data_min_filter);
  var max = params.get('max') ? Number(params.get('max')) : Number(data_max_filter);
  $(function () {
    $("#slider-range").slider({
      range: true,
      min: data_min,
      max: data_max,
      values: [min, max],
      slide: function slide(event, ui) {
        $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
      },
      change: function change(event, ui) {
        var value1 = ui.values[0];
        var value2 = ui.values[1];
        $.ajax({
          type: "GET",
          url: window.location.pathname,
          data: "min=" + value1 + "&max=" + value2,
          // cache: false,
          complete: function complete() {
            window.history.pushState('', "", this.url);
            init_count_select_filters();
            printButtonCancelFilters();
            print_selected_filters();
            setSlideRange();
            filter();
          },
          success: function success(html) {
            $("#common").html(html);
          }
        });
      }
    });
    $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
  });
}

function printButtonCancelFilters() {
  var search = new URLSearchParams(window.location.search);

  if (count_select_checks.size || search.has('min') || search.has('max')) {
    if (!$('#button_cancel').length) {
      var button_cancel = '<button id="button_cancel" type="button" class="btn btn-danger btn-sm mt-3">Cancel All Filters</button>';
      $('#anchor').after(button_cancel);
      $('#button_cancel').on("click", function (event) {
        $.ajax({
          url: '/wheelchairs',
          type: 'GET',
          beforeSend: function beforeSend() {
            count_select_checks.clear();
          },
          complete: function complete() {
            window.history.pushState('', "", '/wheelchairs');
            init_count_select_filters();
            print_selected_filters();
            setSlideRange();
            filter();
          },
          success: function success(html) {
            $("#common").html(html);
          }
        });
      });
    }
  }
}

/***/ }),

/***/ 1:
/*!**************************************!*\
  !*** multi ./resources/js/filter.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! E:\sites\medical-equipment\resources\js\filter.js */"./resources/js/filter.js");


/***/ })

/******/ });