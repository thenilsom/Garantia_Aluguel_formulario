 angular
       .module('app')
       .controller('ListaController', ['$scope', '$http', 'serviceUtil','$timeout', 'validaService','dataUtil',
        function($scope, $http, service, $timeout, validador, dataUtil){

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


        $scope.registro = angular.copy(registro);
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

       $scope.incluirRegistro = function(){
         $http.get('../app/php/consulta.php/dataServidor').then(function(data){
             $scope.errors = [];
             $scope.novoReg = {};
             $scope.novoReg.data = dataUtil.formatarDataServidor(data.data.data);
             $scope.novoReg.hora = data.data.hora;
             listarCGC_Imob();
             $scope.acao = 'incluir';
        }, function(erro){
         service.alertarErro(erro.statusText);
        });
       }

        var validarDadosRegistro = function(form){
             $scope.errors = [];
             validador.validarCamposObrigatorios(form, $scope.errors);

             var isCpf = $scope.novoReg.cpfInquilino.length <= 11;

              if(isCpf && !validador.validarCpf($scope.novoReg.cpfInquilino)){
                $scope.errors.push("CPF inválido");
              }

              if(!isCpf && !validador.validarCNPJ($scope.novoReg.cpfInquilino)){
                $scope.errors.push("CNPJ inválido");
              }

              return $scope.errors.length == 0;
          }


       $scope.gravarRegistro = function(){
        if(validarDadosRegistro('formIncluirRegistro')){
          tratarDadosRegistro()

          $http.post('../app/php/gravar.php/gravarRegInquilino', $scope.novoReg).then(function(data){
           service.alertar('Registro incluido com sucesso!');
            $scope.irParaListagem();
            listar();
          }, function(erro){
            service.alertarErro(erro.statusText);
          });
        }
         
       }

       //trata os dados do registro que será enviado ao servidor
       var tratarDadosRegistro = function(){
         $scope.novoReg.cpfInquilino = service.formatarCpfCnpj($scope.novoReg.cpfInquilino);
         $scope.novoReg.codCorretor = getCodCorretor();
         $scope.novoReg.data = dataUtil.formatarParaDataServidor($scope.novoReg.data);
       }

       //retorna o codigo do corretor
       var getCodCorretor = function(){
        return $("input[name='codigo_corretor']").val();
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
	    		  $http.post('../app/php/gravar.php/registrarAtendimento', atendimento).then(function(data){    
	    			  alert('atendimento registrado');
	    			  listar();
	    		  }, function(erro){
	    			  service.alertarErro(erro.statusText);
	    		  });
	    	  }
    	   });
       }
       
       $scope.isRegPendenteMais30Minutos = function(reg){
    	   return dataUtil.isDifHoraMais30minutos(dataUtil.criarDataHora(reg.data_transm, reg.hora_transm));
       }

       //formata o nome para o link de uploads
       $scope.formatarNomeParaLink = function(nome){
        return nome.replace(/ /g, '_');
       }

       //traz a lista de cgc imob
       var listarCGC_Imob = function(){
         $http.post('../app/php/consulta.php/listarCGC_Imob', {codCorretor: getCodCorretor()}).then(function(data){
            $scope.listaCGC_Imob = data.data;
            
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
       }
       

       $scope.irParaListagem();
       listar();
       ativarRefresh();
    }]);