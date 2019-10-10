 angular
       .module('app')
       .controller('ListaController', ['$scope', '$http', 'serviceUtil','$timeout', 
        function($scope, $http, service, $timeout){

    	var title = 'Seguros Já! - Fiança Locatícia';
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
         $http.post('../app/php/consulta.php/listar', {codigo: codigoParam}).then(function(data){
            $(".loader").removeClass('hidden');
            $scope.listaTabela = data.data;
            alertarQtdRegPendenteNoTitle();
            
            if(qtdRegistros > 0 && qtdRegistros < $scope.listaTabela.length){
              $('#notificacao').trigger('play');
            }

            qtdRegistros = $scope.listaTabela.length;
            
            }, function(erro){
              $(".loader").removeClass('hidden');
             // service.alertarErro(erro.statusText);
            });
       }
       
       /**
        * Alerta a qtd de registros pendentes no title da aba do navegador
        */
       var alertarQtdRegPendenteNoTitle = function(){
    	   var qtdRegPendente = $scope.listaTabela.filter(reg=> reg.data_aceite_analise == '0000-00-00 00:00:00').length;
    	   if(qtdRegPendente > 0){
    		   document.title = '(' + qtdRegPendente + ') ' + title; 
    		   
    	   }else{
    		   document.title = title;
    	   }
       }
       
       //registra o atendimento para o usuário
       $scope.registrarAtendimento = function(registro){
    	   service.showConfirm('Confirma registrar o atendimento ?',function(){
	    	  var codUser = $("input[name='codigo_usuario']").val();
	    	  if(!codUser){
	    		  service.alertarErro('Usuário não identificado.');
	    		  
	    	  }else{
	    		  var atendimento = {codigoUsuario : codUser, codigoCadastro: registro.codigo};
	    		  $http.post('../app/php/consulta.php/registrarAtendimento', atendimento).then(function(data){    
	    			  alert('atendimento registrado');
	    			  listar();
	    		  }, function(erro){
	    			  service.alertarErro(erro.statusText);
	    		  });
	    	  }
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