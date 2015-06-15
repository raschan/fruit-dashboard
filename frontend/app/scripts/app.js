'use strict';

/**
 * @ngdoc overview
 * @name sitesApp
 * @description
 * # sitesApp
 *
 * Main module of the application.
 */
angular
  .module('dashboardApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'ui.bootstrap',
    'gridster'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  })
  .filter('reverse', function() {
    return function (text) {
      return text.split('').reverse().join('');
    };
  })
  .factory('Widgets', function() {
    return [
      { id: 1, size: { x: 2, y: 1 }, position: [0, 0], minSizeY: 1, maxSizeY: 2, hasClosingButton: true},
      { id: 2, size: { x: 2, y: 2 }, position: [0, 2], minSizeY: 1, maxSizeY: 2, hasClosingButton: false},
      { id: 3, size: { x: 1, y: 1 }, position: [0, 4], minSizeY: 1, maxSizeY: 2, hasClosingButton: true},
      { id: 4, size: { x: 1, y: 1 }, position: [0, 5], minSizeY: 1, maxSizeY: 2, hasClosingButton: true},
      { id: 5, size: { x: 2, y: 1 }, position: [1, 0], minSizeY: 1, maxSizeY: 2, hasClosingButton: true},
      { id: 6, size: { x: 1, y: 1 }, position: [1, 4], minSizeY: 1, maxSizeY: 2, hasClosingButton: true},
      { id: 7, size: { x: 1, y: 2 }, position: [1, 5], minSizeY: 1, maxSizeY: 2, hasClosingButton: true},
      { id: 8, size: { x: 1, y: 1 }, position: [2, 0], minSizeY: 1, maxSizeY: 2, hasClosingButton: true},
      { id: 9, size: { x: 2, y: 1 }, position: [2, 1], minSizeY: 1, maxSizeY: 2, hasClosingButton: true},
      { id: 10, size: { x: 1, y: 1 }, position: [2, 3], minSizeY: 1, maxSizeY: 2, hasClosingButton: true},
      { id: 11, size: { x: 1, y: 1 }, position: [2, 4], minSizeY: 1, maxSizeY: 2, hasClosingButton: true}
    ];
  })
  .directive('hover', function(){
    return {
      link: function($scope, element, attrs) {
        element.bind('mouseenter', function() {
          console.log($scope.gridsterItem.col);
          element.removeClass(attrs.hover);  
        });
        element.bind('mouseleave', function() {
          console.log('left');
          element.addClass(attrs.hover);
        });
      }
    };
  });

  