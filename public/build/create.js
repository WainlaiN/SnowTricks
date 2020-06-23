(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["create"],{

/***/ "./assets/js/create.js":
/*!*****************************!*\
  !*** ./assets/js/create.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($, jQuery) {__webpack_require__(/*! core-js/modules/es.array.find */ "./node_modules/core-js/modules/es.array.find.js");

__webpack_require__(/*! core-js/modules/es.function.name */ "./node_modules/core-js/modules/es.function.name.js");

__webpack_require__(/*! core-js/modules/es.regexp.exec */ "./node_modules/core-js/modules/es.regexp.exec.js");

__webpack_require__(/*! core-js/modules/es.string.replace */ "./node_modules/core-js/modules/es.string.replace.js");

$(document).on('change', '.custom-file-input', function (event) {
  var inputFile = event.currentTarget;
  $(inputFile).parent().find('.custom-file-label').html(inputFile.files[0].name);
});
jQuery(document).ready(function () {
  jQuery('.add-another-collection-widget').click(function (e) {
    var list = jQuery(jQuery(this).attr('data-list-selector')); // Try to find the counter of the list or use the length of the list

    var counter = list.data('widget-counter') || list.children().length; // grab the prototype template

    var newWidget = list.attr('data-prototype'); // replace the "__name__" used in the id and name of the prototype
    // with a number that's unique to your emails
    // end name attribute looks like name="contact[emails][2]"

    newWidget = newWidget.replace(/__name__/g, counter); // Increase the counter

    counter++; // And store it, the length cannot be used if deleting widgets is allowed

    list.data('widget-counter', counter); // create a new list element and add it to the list

    var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
    newElem.appendTo(list);
  });
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"), __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/create.js","runtime","vendors~app~btnMedia~carouselJs~create~loadbutton","vendors~create~edit~loadbutton","vendors~create~edit","vendors~create"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvY3JlYXRlLmpzIl0sIm5hbWVzIjpbIiQiLCJkb2N1bWVudCIsIm9uIiwiZXZlbnQiLCJpbnB1dEZpbGUiLCJjdXJyZW50VGFyZ2V0IiwicGFyZW50IiwiZmluZCIsImh0bWwiLCJmaWxlcyIsIm5hbWUiLCJqUXVlcnkiLCJyZWFkeSIsImNsaWNrIiwiZSIsImxpc3QiLCJhdHRyIiwiY291bnRlciIsImRhdGEiLCJjaGlsZHJlbiIsImxlbmd0aCIsIm5ld1dpZGdldCIsInJlcGxhY2UiLCJuZXdFbGVtIiwiYXBwZW5kVG8iXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBQUFBLENBQUMsQ0FBQ0MsUUFBRCxDQUFELENBQVlDLEVBQVosQ0FBZSxRQUFmLEVBQXlCLG9CQUF6QixFQUErQyxVQUFTQyxLQUFULEVBQWdCO0FBQzNELE1BQUlDLFNBQVMsR0FBR0QsS0FBSyxDQUFDRSxhQUF0QjtBQUNBTCxHQUFDLENBQUNJLFNBQUQsQ0FBRCxDQUFhRSxNQUFiLEdBQ0tDLElBREwsQ0FDVSxvQkFEVixFQUVLQyxJQUZMLENBRVVKLFNBQVMsQ0FBQ0ssS0FBVixDQUFnQixDQUFoQixFQUFtQkMsSUFGN0I7QUFHSCxDQUxEO0FBT0FDLE1BQU0sQ0FBQ1YsUUFBRCxDQUFOLENBQWlCVyxLQUFqQixDQUF1QixZQUFZO0FBQy9CRCxRQUFNLENBQUMsZ0NBQUQsQ0FBTixDQUF5Q0UsS0FBekMsQ0FBK0MsVUFBVUMsQ0FBVixFQUFhO0FBQ3hELFFBQUlDLElBQUksR0FBR0osTUFBTSxDQUFDQSxNQUFNLENBQUMsSUFBRCxDQUFOLENBQWFLLElBQWIsQ0FBa0Isb0JBQWxCLENBQUQsQ0FBakIsQ0FEd0QsQ0FFeEQ7O0FBQ0EsUUFBSUMsT0FBTyxHQUFHRixJQUFJLENBQUNHLElBQUwsQ0FBVSxnQkFBVixLQUErQkgsSUFBSSxDQUFDSSxRQUFMLEdBQWdCQyxNQUE3RCxDQUh3RCxDQUt4RDs7QUFDQSxRQUFJQyxTQUFTLEdBQUdOLElBQUksQ0FBQ0MsSUFBTCxDQUFVLGdCQUFWLENBQWhCLENBTndELENBT3hEO0FBQ0E7QUFDQTs7QUFDQUssYUFBUyxHQUFHQSxTQUFTLENBQUNDLE9BQVYsQ0FBa0IsV0FBbEIsRUFBK0JMLE9BQS9CLENBQVosQ0FWd0QsQ0FXeEQ7O0FBQ0FBLFdBQU8sR0FaaUQsQ0FheEQ7O0FBQ0FGLFFBQUksQ0FBQ0csSUFBTCxDQUFVLGdCQUFWLEVBQTRCRCxPQUE1QixFQWR3RCxDQWdCeEQ7O0FBQ0EsUUFBSU0sT0FBTyxHQUFHWixNQUFNLENBQUNJLElBQUksQ0FBQ0MsSUFBTCxDQUFVLGtCQUFWLENBQUQsQ0FBTixDQUFzQ1IsSUFBdEMsQ0FBMkNhLFNBQTNDLENBQWQ7QUFDQUUsV0FBTyxDQUFDQyxRQUFSLENBQWlCVCxJQUFqQjtBQUNILEdBbkJEO0FBb0JILENBckJELEUiLCJmaWxlIjoiY3JlYXRlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiJChkb2N1bWVudCkub24oJ2NoYW5nZScsICcuY3VzdG9tLWZpbGUtaW5wdXQnLCBmdW5jdGlvbihldmVudCkge1xyXG4gICAgdmFyIGlucHV0RmlsZSA9IGV2ZW50LmN1cnJlbnRUYXJnZXQ7XHJcbiAgICAkKGlucHV0RmlsZSkucGFyZW50KClcclxuICAgICAgICAuZmluZCgnLmN1c3RvbS1maWxlLWxhYmVsJylcclxuICAgICAgICAuaHRtbChpbnB1dEZpbGUuZmlsZXNbMF0ubmFtZSk7XHJcbn0pO1xyXG5cclxualF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbiAoKSB7XHJcbiAgICBqUXVlcnkoJy5hZGQtYW5vdGhlci1jb2xsZWN0aW9uLXdpZGdldCcpLmNsaWNrKGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgdmFyIGxpc3QgPSBqUXVlcnkoalF1ZXJ5KHRoaXMpLmF0dHIoJ2RhdGEtbGlzdC1zZWxlY3RvcicpKTtcclxuICAgICAgICAvLyBUcnkgdG8gZmluZCB0aGUgY291bnRlciBvZiB0aGUgbGlzdCBvciB1c2UgdGhlIGxlbmd0aCBvZiB0aGUgbGlzdFxyXG4gICAgICAgIHZhciBjb3VudGVyID0gbGlzdC5kYXRhKCd3aWRnZXQtY291bnRlcicpIHx8IGxpc3QuY2hpbGRyZW4oKS5sZW5ndGg7XHJcblxyXG4gICAgICAgIC8vIGdyYWIgdGhlIHByb3RvdHlwZSB0ZW1wbGF0ZVxyXG4gICAgICAgIHZhciBuZXdXaWRnZXQgPSBsaXN0LmF0dHIoJ2RhdGEtcHJvdG90eXBlJyk7XHJcbiAgICAgICAgLy8gcmVwbGFjZSB0aGUgXCJfX25hbWVfX1wiIHVzZWQgaW4gdGhlIGlkIGFuZCBuYW1lIG9mIHRoZSBwcm90b3R5cGVcclxuICAgICAgICAvLyB3aXRoIGEgbnVtYmVyIHRoYXQncyB1bmlxdWUgdG8geW91ciBlbWFpbHNcclxuICAgICAgICAvLyBlbmQgbmFtZSBhdHRyaWJ1dGUgbG9va3MgbGlrZSBuYW1lPVwiY29udGFjdFtlbWFpbHNdWzJdXCJcclxuICAgICAgICBuZXdXaWRnZXQgPSBuZXdXaWRnZXQucmVwbGFjZSgvX19uYW1lX18vZywgY291bnRlcik7XHJcbiAgICAgICAgLy8gSW5jcmVhc2UgdGhlIGNvdW50ZXJcclxuICAgICAgICBjb3VudGVyKys7XHJcbiAgICAgICAgLy8gQW5kIHN0b3JlIGl0LCB0aGUgbGVuZ3RoIGNhbm5vdCBiZSB1c2VkIGlmIGRlbGV0aW5nIHdpZGdldHMgaXMgYWxsb3dlZFxyXG4gICAgICAgIGxpc3QuZGF0YSgnd2lkZ2V0LWNvdW50ZXInLCBjb3VudGVyKTtcclxuXHJcbiAgICAgICAgLy8gY3JlYXRlIGEgbmV3IGxpc3QgZWxlbWVudCBhbmQgYWRkIGl0IHRvIHRoZSBsaXN0XHJcbiAgICAgICAgdmFyIG5ld0VsZW0gPSBqUXVlcnkobGlzdC5hdHRyKCdkYXRhLXdpZGdldC10YWdzJykpLmh0bWwobmV3V2lkZ2V0KTtcclxuICAgICAgICBuZXdFbGVtLmFwcGVuZFRvKGxpc3QpO1xyXG4gICAgfSk7XHJcbn0pO1xyXG4iXSwic291cmNlUm9vdCI6IiJ9