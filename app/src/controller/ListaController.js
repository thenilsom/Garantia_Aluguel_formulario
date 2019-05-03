 angular
       .module('app')
       .controller('ListaController', ['$scope', '$http', 'serviceUtil', 
        function($scope, $http, service){

       
       $scope.acao = 'listar';

       $scope.listaTabela = [];

       var listar = function(){
         $http.get('http://www.segurosja.com.br/gerenciador/fianca/app/php/consulta.php/listar').then(function(data){
            $scope.listaTabela.push(data.data.root_name);
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
       }

       $scope.getTelefoneInquilino = function(registro){
        if(registro.cel_inquilino) return registro.cel_inquilino;
        if(registro.fone_inquilino) return registro.fone_inquilino;
        if(registro.fone_com_inquilino) return registro.fone_com_inquilino;
       }

       listar();
    }]);