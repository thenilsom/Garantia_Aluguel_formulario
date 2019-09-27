 angular
       .module('app')
       .controller('ListaController', ['$scope', '$http', 'serviceUtil','$timeout', 
        function($scope, $http, service, $timeout){

        var qtdRegistros = 0;
        var TEMPO_REFRESH = 60;
        $scope.contador = TEMPO_REFRESH;
        $scope.promise;

        //obtem os parametros na url se existir
        var codigoParam = null;
        var paramUrl = service.extraiParamUrl(location.search.slice(1));
        if(paramUrl)
          codigoParam = service.decriptografar(paramUrl['var']);

     
       $scope.listaTabela = [];

       /**
       * thread para ficar verificando se existe um novo atendimento,
       * se existir atualiza a listagem
       */
      var ativarRefresh = function(){
        $scope.contador--;
        if($scope.contador === 0){
          $(".loader").addClass('hidden');// parar a execução do popUp de carregamento
          listar();
          $scope.contador = TEMPO_REFRESH;
        }
        
        $scope.promise = $timeout(ativarRefresh, 1000);
      }

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
         $http.post('http://www.segurosja.com.br/gerenciador/fianca/app/php/consulta.php/listar', {codigo: codigoParam}).then(function(data){
            $(".loader").removeClass('hidden');
            $scope.listaTabela = data.data;
            if(qtdRegistros > 0 && qtdRegistros < $scope.listaTabela.length){
              $('#notificacao').trigger('play');
            }

            qtdRegistros = $scope.listaTabela.length;
            
            }, function(erro){
              $(".loader").removeClass('hidden');
             // service.alertarErro(erro.statusText);
            });
       }
       
       $scope.registrarAtendimento = function(registro){
    	   service.showConfirm('Confirma registrar o atendimento ?',function(){
    		   registro.data_aceite_analise = 'data atual';
    		   registro.usuario_analise = 'codigo usuario';
    		   alert('atendimento registrado');
    	   });
       }

       //formata o nome para o link de uploads
       $scope.formatarNomeParaLink = function(nome){
        return nome.replace(/ /g, '_');
       }
       

       $scope.irParaListagem();
       listar();
       ativarRefresh();
    }]);