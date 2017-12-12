(function(){
  'use strict';

  // Prepare the 'users' module for subsequent registration of controllers and delegates
  angular.module('app', [ 'ngMaterial', 'diretiva', 'angularFileUpload' ])
  .run(function($mdDateLocale, $filter) {
        $mdDateLocale.formatDate = function(date) {
            return $filter('date')(date, "dd/MM/yyyy");
        };
    })


})();
