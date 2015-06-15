'use strict';

/**
 * @ngdoc function
 * @name sitesApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the sitesApp
 */
angular
  .module('dashboardApp')
  .controller('MainCtrl', function () {
    
  })
  .controller('SettingsCtrl', function ($scope) {
    $scope.status = {
      isopen: false
    };

    $scope.toggleDropdown = function($event) {
      $event.preventDefault();
      $event.stopPropagation();
      $scope.status.isopen = !$scope.status.isopen;
    };
  })
  .controller('DashboardCtrl', function ($scope, Widgets) {
    this.widgets = Widgets;

    // maps the item from customItems in the scope to the gridsterItem options
    $scope.customItemMap = {
        sizeX: 'widget.size.x',
        sizeY: 'widget.size.y',
        row: 'widget.position[0]',
        col: 'widget.position[1]',
        minSizeY: 'widget.minSizeY',
        maxSizeY: 'widget.maxSizeY'
    };
  });