 angular
       .module('app')
       .controller('ListaController', ['$scope', '$http', 'serviceUtil', 
        function($scope, $http, service){

       
       $scope.acao = 'listar';

       $scope.listaTabela = [];

       var listar = function(){
         $http.get('http://www.segurosja.com.br/gerenciador/fianca/app/php/consulta.php/listar').then(function(data){
            $scope.listaTabela = data.data;
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
       }

      
       listar();
    }]);