 angular
       .module('app')
       .controller('ListaController', ['$scope', '$http', 'serviceUtil','$timeout', 
        function($scope, $http, service, $timeout){

     
       $scope.listaTabela = [];

       $scope.detalhar = function(registro){

        for (var key in registro) {
          if(!registro[key])
            registro[key] = '--';
        }

        $timeout(function(){
          $("#accordion a:first").trigger("click");
        });


        $scope.registro = registro;
        $scope.acao = 'detalhar';

       }

       $scope.irParaListagem = function(){
        $scope.acao = 'listar';
       }

       var listar = function(){
         $http.get('http://www.segurosja.com.br/gerenciador/fianca/app/php/consulta.php/listar').then(function(data){
            $scope.listaTabela = data.data;
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
       }

       $scope.irParaListagem();
       listar();
    }]);