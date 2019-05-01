 angular
       .module('app')
       .controller('ListaController', ['$scope', '$http', 'serviceUtil', 
        function($scope, $http, service){

       
       $scope.acao = 'listar';

       $scope.listaTabela = [{nome:'Denilson', cpf:'026.715.34140', telefone: '99451-5367'},
       {nome:'Vanessa', cpf:'026.715.34140', telefone: '99451-5367'},
       {nome:'Danilo', cpf:'033.222.34140', telefone: '99351-5588'}]

       var listar = function(){
         $http.get('http://www.segurosja.com.br/gerenciador/fianca/app/php/consulta.php/listar').then(function(data){
            console.log(data);
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
       }

       listar();
    }]);