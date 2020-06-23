(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["edit"],{

/***/ "./assets/js/edit.js":
/*!***************************!*\
  !*** ./assets/js/edit.js ***!
  \***************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! core-js/modules/es.symbol */ "./node_modules/core-js/modules/es.symbol.js");

__webpack_require__(/*! core-js/modules/es.symbol.description */ "./node_modules/core-js/modules/es.symbol.description.js");

__webpack_require__(/*! core-js/modules/es.symbol.iterator */ "./node_modules/core-js/modules/es.symbol.iterator.js");

__webpack_require__(/*! core-js/modules/es.array.from */ "./node_modules/core-js/modules/es.array.from.js");

__webpack_require__(/*! core-js/modules/es.array.is-array */ "./node_modules/core-js/modules/es.array.is-array.js");

__webpack_require__(/*! core-js/modules/es.array.iterator */ "./node_modules/core-js/modules/es.array.iterator.js");

__webpack_require__(/*! core-js/modules/es.array.slice */ "./node_modules/core-js/modules/es.array.slice.js");

__webpack_require__(/*! core-js/modules/es.date.to-string */ "./node_modules/core-js/modules/es.date.to-string.js");

__webpack_require__(/*! core-js/modules/es.function.name */ "./node_modules/core-js/modules/es.function.name.js");

__webpack_require__(/*! core-js/modules/es.object.to-string */ "./node_modules/core-js/modules/es.object.to-string.js");

__webpack_require__(/*! core-js/modules/es.promise */ "./node_modules/core-js/modules/es.promise.js");

__webpack_require__(/*! core-js/modules/es.regexp.to-string */ "./node_modules/core-js/modules/es.regexp.to-string.js");

__webpack_require__(/*! core-js/modules/es.string.iterator */ "./node_modules/core-js/modules/es.string.iterator.js");

__webpack_require__(/*! core-js/modules/web.dom-collections.iterator */ "./node_modules/core-js/modules/web.dom-collections.iterator.js");

function _createForOfIteratorHelper(o) { if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) { var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var it, normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

window.onload = function () {
  //manage delete button
  var links = document.querySelectorAll("[data-delete]");
  console.log(links); //loop on links(data-delete) buttons

  var _iterator = _createForOfIteratorHelper(links),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      link = _step.value;
      //listening to the click
      link.addEventListener("click", function (e) {
        var _this = this;

        //prevent the click
        e.preventDefault(); //ask for confirmation

        if (confirm("Voulez-vous supprimer cette image ?")) {
          //send AJAX request to the href with DELETE method
          fetch(this.getAttribute("href"), {
            method: "DELETE",
            headers: {
              "X-Requested-With": "XMLHttpRequest",
              "Content-Type": "application/json"
            }
          }).then( //get the JSON response
          function (response) {
            return response.json();
          }).then(function (data) {
            if (data.success) _this.parentElement.remove();else alert(data.error);
          })["catch"](function (e) {
            return alert(e);
          });
        }
      });
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
};

/***/ })

},[["./assets/js/edit.js","runtime","vendors~create~edit~loadbutton","vendors~create~edit","vendors~edit"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZWRpdC5qcyJdLCJuYW1lcyI6WyJ3aW5kb3ciLCJvbmxvYWQiLCJsaW5rcyIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvckFsbCIsImNvbnNvbGUiLCJsb2ciLCJsaW5rIiwiYWRkRXZlbnRMaXN0ZW5lciIsImUiLCJwcmV2ZW50RGVmYXVsdCIsImNvbmZpcm0iLCJmZXRjaCIsImdldEF0dHJpYnV0ZSIsIm1ldGhvZCIsImhlYWRlcnMiLCJ0aGVuIiwicmVzcG9uc2UiLCJqc29uIiwiZGF0YSIsInN1Y2Nlc3MiLCJwYXJlbnRFbGVtZW50IiwicmVtb3ZlIiwiYWxlcnQiLCJlcnJvciJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQUFBQSxNQUFNLENBQUNDLE1BQVAsR0FBZ0IsWUFBTTtBQUVsQjtBQUNBLE1BQUlDLEtBQUssR0FBR0MsUUFBUSxDQUFDQyxnQkFBVCxDQUEwQixlQUExQixDQUFaO0FBQ0FDLFNBQU8sQ0FBQ0MsR0FBUixDQUFZSixLQUFaLEVBSmtCLENBTWxCOztBQU5rQiw2Q0FPTEEsS0FQSztBQUFBOztBQUFBO0FBT2xCLHdEQUFvQjtBQUFmSyxVQUFlO0FBQ2hCO0FBQ0FBLFVBQUksQ0FBQ0MsZ0JBQUwsQ0FBc0IsT0FBdEIsRUFBK0IsVUFBVUMsQ0FBVixFQUFhO0FBQUE7O0FBQ3hDO0FBQ0FBLFNBQUMsQ0FBQ0MsY0FBRixHQUZ3QyxDQUl4Qzs7QUFDQSxZQUFJQyxPQUFPLENBQUMscUNBQUQsQ0FBWCxFQUFvRDtBQUNoRDtBQUNBQyxlQUFLLENBQUMsS0FBS0MsWUFBTCxDQUFrQixNQUFsQixDQUFELEVBQTRCO0FBQzdCQyxrQkFBTSxFQUFFLFFBRHFCO0FBRTdCQyxtQkFBTyxFQUFFO0FBQ0wsa0NBQW9CLGdCQURmO0FBRUwsOEJBQWdCO0FBRlg7QUFGb0IsV0FBNUIsQ0FBTCxDQU1HQyxJQU5ILEVBT0k7QUFDQSxvQkFBQUMsUUFBUTtBQUFBLG1CQUFJQSxRQUFRLENBQUNDLElBQVQsRUFBSjtBQUFBLFdBUlosRUFTRUYsSUFURixDQVNPLFVBQUFHLElBQUksRUFBSTtBQUNYLGdCQUFJQSxJQUFJLENBQUNDLE9BQVQsRUFDSSxLQUFJLENBQUNDLGFBQUwsQ0FBbUJDLE1BQW5CLEdBREosS0FHSUMsS0FBSyxDQUFDSixJQUFJLENBQUNLLEtBQU4sQ0FBTDtBQUNQLFdBZEQsV0FjUyxVQUFBZixDQUFDO0FBQUEsbUJBQUljLEtBQUssQ0FBQ2QsQ0FBRCxDQUFUO0FBQUEsV0FkVjtBQWVIO0FBQ0osT0F2QkQ7QUF3Qkg7QUFqQ2lCO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFrQ3JCLENBbENELEMiLCJmaWxlIjoiZWRpdC5qcyIsInNvdXJjZXNDb250ZW50IjpbIndpbmRvdy5vbmxvYWQgPSAoKSA9PiB7XHJcblxyXG4gICAgLy9tYW5hZ2UgZGVsZXRlIGJ1dHRvblxyXG4gICAgbGV0IGxpbmtzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWRlbGV0ZV1cIilcclxuICAgIGNvbnNvbGUubG9nKGxpbmtzKVxyXG5cclxuICAgIC8vbG9vcCBvbiBsaW5rcyhkYXRhLWRlbGV0ZSkgYnV0dG9uc1xyXG4gICAgZm9yIChsaW5rIG9mIGxpbmtzKSB7XHJcbiAgICAgICAgLy9saXN0ZW5pbmcgdG8gdGhlIGNsaWNrXHJcbiAgICAgICAgbGluay5hZGRFdmVudExpc3RlbmVyKFwiY2xpY2tcIiwgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgLy9wcmV2ZW50IHRoZSBjbGlja1xyXG4gICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KClcclxuXHJcbiAgICAgICAgICAgIC8vYXNrIGZvciBjb25maXJtYXRpb25cclxuICAgICAgICAgICAgaWYgKGNvbmZpcm0oXCJWb3VsZXotdm91cyBzdXBwcmltZXIgY2V0dGUgaW1hZ2UgP1wiKSkge1xyXG4gICAgICAgICAgICAgICAgLy9zZW5kIEFKQVggcmVxdWVzdCB0byB0aGUgaHJlZiB3aXRoIERFTEVURSBtZXRob2RcclxuICAgICAgICAgICAgICAgIGZldGNoKHRoaXMuZ2V0QXR0cmlidXRlKFwiaHJlZlwiKSwge1xyXG4gICAgICAgICAgICAgICAgICAgIG1ldGhvZDogXCJERUxFVEVcIixcclxuICAgICAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIFwiWC1SZXF1ZXN0ZWQtV2l0aFwiOiBcIlhNTEh0dHBSZXF1ZXN0XCIsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIFwiQ29udGVudC1UeXBlXCI6IFwiYXBwbGljYXRpb24vanNvblwiXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfSkudGhlbihcclxuICAgICAgICAgICAgICAgICAgICAvL2dldCB0aGUgSlNPTiByZXNwb25zZVxyXG4gICAgICAgICAgICAgICAgICAgIHJlc3BvbnNlID0+IHJlc3BvbnNlLmpzb24oKVxyXG4gICAgICAgICAgICAgICAgKS50aGVuKGRhdGEgPT4ge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChkYXRhLnN1Y2Nlc3MpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMucGFyZW50RWxlbWVudC5yZW1vdmUoKVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgICAgICAgICAgYWxlcnQoZGF0YS5lcnJvcilcclxuICAgICAgICAgICAgICAgIH0pLmNhdGNoKGUgPT4gYWxlcnQoZSkpXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9KVxyXG4gICAgfVxyXG59XHJcbiJdLCJzb3VyY2VSb290IjoiIn0=