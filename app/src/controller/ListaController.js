 angular
       .module('app')
       .controller('ListaController', ['$scope', '$http', 'serviceUtil','$timeout', 
        function($scope, $http, service, $timeout){

        //obtem os parametros na url se existir
        var codigoParam = null;
        var paramUrl = service.extraiParamUrl(location.search.slice(1));
        if(paramUrl)
          codigoParam = service.decriptografar(paramUrl['var']);

     
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
         $http.post('../app/php/consulta.php/consulta.php/listar', {codigo: codigoParam}).then(function(data){
            $scope.listaTabela = data.data;
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
       }

       //formata o nome para o link de uploads
       $scope.formatarNomeParaLink = function(nome){
        return nome.replace(/ /g, '_');
       }

       $scope.irParaListagem();
       listar();
    }]);