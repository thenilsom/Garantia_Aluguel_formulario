 angular
       .module('app')
       .controller('ListaController', ['$scope', '$http', 'serviceUtil','$timeout', 'validaService','dataUtil','FileUploader',
        function($scope, $http, service, $timeout, validador, dataUtil,FileUploader){

    	var url = service.getUrl();
    		
    	var title = 'Seguros Já! - Fiança Locatícia';
        var qtdRegistros = 0;
        var TEMPO_REFRESH = 60;
        $scope.contador = TEMPO_REFRESH;
        $scope.promise;

        //obtem os parametros na url se existir
        var codigoParam = null;
        var codigoUserParam = null;
        var isIncluirParam = false;
        
        var paramUrl = service.extraiParamUrl(location.search.slice(1));
        
        if(paramUrl){
        	codigoParam = service.decriptografar(paramUrl['var']);
        	codigoUserParam = paramUrl['codUser'];
        	isIncluirParam = paramUrl['isIncluir'];
        }

     
       $scope.filtro = {};
       var listaAux = [];
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
        $http.post(url + 'php/consulta.php/fezUploadArquivos', {pasta: $scope.gerarLinkPastaUpload(registro)}).then(function(data){ 
             $scope.registro = angular.copy(registro);
             listarSeguradoras();
             listarFormasPgtoPorto();
            $scope.registro.fezUpload = data.data.qtd > 0;
            
          //obtem o nome do usuario da contratação pelo codigo
            if(registro.usuario_contratacao){
            	var arry = registro.usuario_contratacao.split('_');
            	if(arry.length == 2){
            		 $http.post(url + 'php/consulta.php/consultarPorCodigoUsuario', {codigoUser: arry[1], nivel : arry[0]}).then(function(data){
               		  if(data.data && data.data.nome){
               			  $scope.registro.usuarioContratacao = data.data.nome;
               		  }
                    }, function(erro){
                      service.alertarErro(erro.statusText);
                    });
            	}
            }

            $timeout(function(){
            	if($scope.registro.data_contratacao && $scope.registro.data_contratacao !== '0000-00-00 00:00:00'){
            		$('#collapseContratacao').trigger("click");
            	}else{
            		$("#accordion a:first").trigger("click");
            	}
            });

            marcarSeFezUploadApolice($scope.registro, $scope.registro.codigo, $scope.registro.seguradora);
            $scope.acao = 'detalhar'; 

            }, function(erro){
             service.alertarErro(erro.statusText);
            });

       }

       $scope.irParaListagem = function(){
        $scope.acao = 'listar';
       }
       
       $scope.filtroLista = function (input, search_param) {
    	   return !search_param || (input && input.toString().toLocaleLowerCase().includes(search_param.toLocaleLowerCase()));
    	 }
       
       /**
        * Filtro de lista
        */
       $scope.filtroPorSituacao = function () {
    	   if(angular.equals($scope.filtro.situacao, 'nao_registrado')){
    		   $scope.listaTabela = listaAux.filter(r=> !r.usuario_atendente);
    	   }else if(angular.equals($scope.filtro.situacao, 'contratado')){
    		   $scope.listaTabela = listaAux.filter(r=>r.data_contratacao && !r.data_contratacao.startsWith('0000'));
    		  
    	   }else{
    		   $scope.listaTabela = listaAux;
    	   }
    	 }

       var listar = function(){
         $http.post(url + 'php/consulta.php/listar', {codigo: codigoParam}).then(function(data){
            $(".loader").removeClass('hidden');
            $scope.listaTabela = data.data;
            listaAux = data.data;
            $scope.listaTabela.forEach(l=> l.codigo = parseInt(l.codigo));//converte codigo para inteiro pro filtro da listagem
            montarArrayImobiliarias($scope.listaTabela);
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
        * Consulta a análise nas seguradoras
        */
       $scope.consultarAnaliseNasSeguradoras = function(registro, tipo){
     	  var situacao = tipo == 'lib' ?  registro.situacao_analise_liberty : (tipo == 'por' ? registro.situacao_analise_porto : '');
     	  
     	  if(situacao && !situacao.toLocaleLowerCase().includes('aprovad') && !situacao.toLocaleLowerCase().includes('recusad') && !situacao.toLocaleLowerCase().includes('reprovad')){
     		  if(tipo == 'por'){
     			  $http.get("https://www.segurosja.com.br/gerenciador/aplicacao_porto/api_resposta.php?codigo_fianca="+registro.codigo+"&gera_analise=0").then(function(data){
     				 listar();
     				 enviaEmails(registro.codigo);//envia email
     			  }, function(erro){
     				  service.alertarErro(erro.statusText);
     			  });
     			  
     		  }else if(tipo == 'lib'){
     			  $http.get("https://www.segurosja.com.br/gerenciador/aplicacao_liberty_fianca/api_resposta.php?codigo_fianca="+registro.codigo +"&gera_analise=0").then(function(data){
     				 listar();
     				 enviaEmails(registro.codigo);//envia email
     			  }, function(erro){
     				  service.alertarErro(erro.statusText);
     			  });
     		  }
     	  }
       }
       
       /**
        * Lista as Seguradoras
        */
       var listarSeguradoras = function(){
           $http.get(url + 'php/consulta.php/listarSeguradoras').then(function(data){
              $scope.listaSeguradoras = data.data;
              }, function(erro){
               service.alertarErro(erro.statusText);
              });
         }
       
       /**
        * Lista as formas pgto porto
        */
       var listarFormasPgtoPorto = function(){
           $http.get(url + 'php/consulta.php/listarFormasPgtoPorto').then(function(data){
              $scope.listaFormasPgtoPorto = data.data;
              }, function(erro){
               service.alertarErro(erro.statusText);
              });
         }
       
       /**
        * Monta o array de lista das imobiliárias
        */
       var montarArrayImobiliarias = function(lista){
    	   $scope.listaImobiliarias = [...new Set(lista.filter(l=> l.fantasia).map(v=> v.fantasia))].sort();
       }
       
       /**
        * Redireciona para o formulario
        */
       $scope.enviarAnalise = function(){
    	   window.location.href = url + 'index.php?var1=' + service.criptografar(service.apenasNumeros($scope.novoReg.cgcImob.cpf))
    	   											+ '&var9=' + $scope.novoReg.inquilino
    	   											+ '&var10=' + service.criptografar($scope.novoReg.cpfInquilino)
    	   											+ '&var11=' + $scope.novoReg.tipoInquilino;
       }

       $scope.incluirRegistro = function(){
         $http.get(url + 'php/consulta.php/dataServidor').then(function(data){
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

              if(isCpf){
            	  if(angular.equals($scope.novoReg.tipoInquilino, 'J')){
                      $scope.errors.push("Para pessoa jurídica deve ser informado um CNPJ");

                    }else if(!validador.validarCpf($scope.novoReg.cpfInquilino)){
            		  $scope.errors.push("CPF inválido");
            	  }
              }

              if(!isCpf){
                if(angular.equals($scope.novoReg.tipoInquilino, 'F')){
                  $scope.errors.push("Para pessoa física deve ser informado um CPF");

                }else if(!validador.validarCNPJ($scope.novoReg.cpfInquilino)){
                  $scope.errors.push("CNPJ inválido");
                }
                
              }

              return $scope.errors.length == 0;
          }
        
        //valida os dados da apolice
        var validarDadosApolice = function(){
        	 $scope.errors = [];
             validador.validarCamposObrigatorios('formApolice', $scope.errors);
             
             return $scope.errors.length == 0;
        }
        
      //valida os dados da analise
        var validarDadosAnalise = function(){
        	 $scope.errors = [];
             validador.validarCamposObrigatorios('formAnalise', $scope.errors);
             
        if(!$scope.primeiraOpSituacao.includes($scope.dadosAnalise.situacao)){
        	$scope.dadosAnalise.dataAprovacao = null;
        }
             
             return $scope.errors.length == 0;
        }


       $scope.gravarRegistro = function(){
        if(validarDadosRegistro('formIncluirRegistro')){
          tratarDadosRegistro()
          $scope.novoReg.status = '1';
          
          $http.post(url + 'php/gravar.php/gravarRegInquilino', $scope.novoReg).then(function(data){
           service.alertar('Registro incluido com sucesso!');
            $scope.irParaListagem();
            listar();
          }, function(erro){
            service.alertarErro(erro.statusText);
          });
        }
         
       }
       
       //grava os dados da apolice
       $scope.gravarDadosApolice = function(){
    	   if(validarDadosApolice()){
    		   $scope.dadosAplice.codSeguradora = $scope.dadosAplice.objSeguradora.sigla;
    		   $scope.dadosAplice.objSeguradora = null;
    		   if($scope.dadosAplice.data && $scope.dadosAplice.hora){
    			   $scope.dadosAplice.data_contratacao = dataUtil.formatarParaDataServidor($scope.dadosAplice.data) + ' ' + $scope.dadosAplice.hora;
    		   }
    		   $http.post(url + 'php/gravar.php/gravarDadosApolice', $scope.dadosAplice).then(function(data){
    			   enviarArquivosUploadApolice();
    			   $('#modalDadosApolice').modal('hide');
    			   service.alertar('Dados da apólice atualizado com sucesso!');
    			   $scope.registro.apolice = $scope.dadosAplice.numApolice;
    			   $scope.registro.seguradora = $scope.dadosAplice.codSeguradora;
    		   }, function(erro){
    			   service.alertarErro(erro.statusText);
    		   });
    	   }
          }
       
     //grava os dados da analise
       $scope.gravarDadosAnalise= function(){
    	   if(validarDadosAnalise()){
    		   $scope.dadosAnalise.dataAprovacao = dataUtil.formatarParaDataServidor($scope.dadosAnalise.dataAprovacao);
    		   $http.post(url + 'php/gravar.php/alterarDadosAnalise', $scope.dadosAnalise).then(function(data){
    			   
    			   $http.post(url + 'php/consulta.php/consultarPorCodigoRegistro', {codigo: $scope.dadosAnalise.codigoCadastro}).then(function(data){
    				   		$scope.detalhar(data.data[0]);
    				   		$('#modalDadosAnalise').modal('hide');
    		    			 service.alertar('Dados da análise atualizado com sucesso!');
    		    			 enviaEmails($scope.dadosAnalise.codigoCadastro);//envia email
    		            }, function(erro){
    		              service.alertarErro(erro.statusText);
    		            });
    			   
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
        var codigo = $("input[name='codigo_corretor']").val();
        if(codigo){
        	return codigo;
        }else{
        	return codigoParam;
        }
        
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
	    	  var codUser = getCodigoUser();
	    	  if(!codUser){
	    		  service.alertarErro('Usuário não identificado.');
	    		  
	    	  }else{
	    		  var atendimento = {codigoUsuario : codUser, codigoCadastro: registro.codigo};
	    		  $http.post(url + 'php/gravar.php/registrarAtendimento', atendimento).then(function(data){    
	    			  alert('atendimento registrado');
	    			  listar();
	    		  }, function(erro){
	    			  service.alertarErro(erro.statusText);
	    		  });
	    	  }
    	   });
       }
       
       /**
        * Devolve o codigo do usuario
        */
       var getCodigoUser = function(){
    	   var codigo = $("input[name='codigo_usuario']").val();
    	   return codigo ? codigo : codigoUserParam;
       }
       
       $scope.isRegPendenteMais30Minutos = function(reg){
    	   return dataUtil.isDifHoraMais30minutos(dataUtil.criarDataHora(reg.data_transm, reg.hora_transm));
       }

       //formata o nome para o link de uploads
       $scope.gerarLinkPastaUpload = function(registro){
        return service.gerarLinkPastaUpload(registro.codigo, registro.inquilino);
       }

       //traz a lista de cgc imob
       var listarCGC_Imob = function(){
         $http.post(url + 'php/consulta.php/listarCGC_Imob', {codCorretor: getCodCorretor()}).then(function(data){
            $scope.listaCGC_Imob = data.data;
            
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
       }
       
     //traz a lista de opções de cartas
       $scope.listarOpCartaOferta = function(){
         $http.post(url + 'php/consulta.php/listarOpCartas', {cpf: $scope.registro.CGC_imob}).then(function(data){
            $scope.listaOpCartas = [];
            if(data.data && data.data.length > 0){
            	if(data.data[0].carta_of_lib_fianca > 0)
            		$scope.listaOpCartas.push({'descricao': 'Carta Desconto Especial 19-N.' + data.data[0].carta_of_lib_fianca, 'codigo': data.data[0].carta_of_lib_fianca});
            	
            	if(data.data[0].carta_of_lib_fianca_variavel > 0)
            		$scope.listaOpCartas.push({'descricao': 'Carta Comissão Variável-N.' + data.data[0].carta_of_lib_fianca_variavel, 'codigo': data.data[0].carta_of_lib_fianca_variavel});
            	
            	if(data.data[0].carta_of_lib_fianca_tombamento > 0)
            		$scope.listaOpCartas.push({'descricao': 'Carta Tombamento Cardif-N.' + data.data[0].carta_of_lib_fianca_tombamento, 'codigo': data.data[0].carta_of_lib_fianca_tombamento});
            	
            	$scope.registro.opCartaOferta = $scope.listaOpCartas[0];
             }
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
       }
       
       
       /**
        * Inicia os dados da aplice
        */
       $scope.iniciarDadosAplice = function(){
    	   $http.get(url + 'php/consulta.php/dataServidor').then(function(data){
    		   $scope.dadosAplice = {
    				   objSeguradora : $scope.listaSeguradoras.filter(i=> i.sigla == $scope.registro.seguradora)[0],
    				   codigoCadastro : $scope.registro.codigo,
    				   numApolice : $scope.registro.apolice, 
    				   data : dataUtil.formatarDataServidor(data.data.data),
    		           hora : data.data.hora,
    				   codSeguradora : $scope.registro.seguradora};
    		   
    		   if($scope.registro.data_contratacao && !$scope.registro.data_contratacao.startsWith('00')){
    			   var array =$scope.registro.data_contratacao.split(' ');
    			   $scope.dadosAplice.data = dataUtil.formatarData(array[0]);
    			   $scope.dadosAplice.hora = array[1];
    		   }
    		   
    		   if($scope.dadosAplice.objSeguradora && $scope.dadosAplice.objSeguradora.sigla){
    			   marcarSeFezUploadApolice($scope.dadosAplice, $scope.dadosAplice.codigoCadastro, $scope.dadosAplice.objSeguradora.sigla);
    		   }
    		   
    		   iniciarUpload($scope.registro.codigo);
    		   
          }, function(erro){
           service.alertarErro(erro.statusText);
          });
       }
       
       /**
        * Marca se fez upload da apolice
        */
       var marcarSeFezUploadApolice = function(registro, codigo, seguradora){
    	   $.ajax({
               type: 'get',
               url: $scope.gerarUrlUploadApolice(codigo, seguradora),
               success: function (response) {
               },error: function (response) {
                  if(response.statusText == 'OK' || response.status == 200){
                	  registro.fezUploadApolice = true;
                  }
               },
               dataType: 'json',
               global: false
           });
       }
       
       /**
        * Gera a url de acesso a apolice
        */
       $scope.gerarUrlUploadApolice = function(codigo, seguradora){
    	   var arquivo = 'semanexo.pdf';
    	   if(codigo && seguradora){
    		   arquivo =  codigo + '_' +  seguradora.substr(0,3).toLowerCase() + '.pdf';
    	   }
    	   
    	   return "http://www.segurosja.com.br/sistema_seguros/sistemaimobiliario/api/admin/fianca/uploads/" + arquivo;
       }
       
       /*inicia as configurações de upload*/
       var iniciarUpload = function(codigoCadastro){
         $scope.uploader = new FileUploader({
           url : 'https://www.segurosja.com.br/sistema_seguros/sistemaimobiliario/api/admin/fianca/uploadApolice.php',
           formData:[{codigo: codigoCadastro}]
         });

         /*função chamada antes de fazer upload do item*/
         $scope.uploader.onAfterAddingFile   = function(item) {
        	 if($scope.dadosAplice.fezUpload){
        		 if(!confirm("Já existe um arquivo de apólice no servidor. Deseja sobrescrever o arquivo existente")){
        			 item.remove();
        			 $( "#files" ).val("")
        		 }
        	 }
         };
         
        /*função chamada em caso de erro no upload*/
       $scope.uploader.onErrorItem = function(fileItem, response, status, headers) {
         console.info('onErrorItem', fileItem, response, status, headers);
         service.alertarErro(response);
       };
       
     } 
       
       /*Envia o upload dos arquivos*/
       var enviarArquivosUploadApolice = function(){
    	   if($scope.uploader.queue.length > 0){
    		   $scope.uploader.queue.forEach(function(item, index){
    			   var arrayName = item.file.name.split('.');
    			   var seguradora = $scope.dadosAplice.codSeguradora.toLowerCase();
    			   var extensao = '.' + arrayName[arrayName.length - 1];
    			   if(index == 0){
    				   item.file.name = $scope.registro.codigo + '_' + seguradora + extensao;
    			   }else{
    				   item.file.name = $scope.registro.codigo + '_' + index + '_' + seguradora + extensao;
    			   }
    		   });
    		   $scope.uploader.uploadAll();
    	   }
       }
       
       /**
        * Inicia os dados da analise
        */
       $scope.iniciarDadosAnalise = function(registro, tipo){
    	   if(angular.equals(tipo, 'liberty')){
    		   $scope.dadosAnalise = {analise: registro.processo_liberty, 
    				   								situacao: registro.situacao_analise_liberty,
    				   								dataAprovacao : dataUtil.isDataValida(registro.data_aprovacao_liberty) ? dataUtil.formatarData(registro.data_aprovacao_liberty) : dataUtil.getDataAtual()};
    		   
    		   $scope.listaOpAnalise = ['Análise Cadastral Aprovada', 'Em Análise Pela Companhia', 'Análise Cadastral Reprovada', 'Pendente'];
    		   
    	   }else if(angular.equals(tipo, 'porto')){
    		   $scope.dadosAnalise = {analise: registro.processo_porto, 
													situacao: registro.situacao_analise_porto,
													dataAprovacao : dataUtil.isDataValida(registro.data_aprovacao_porto) ? dataUtil.formatarData(registro.data_aprovacao_porto) : dataUtil.getDataAtual()};
    		   
    		   $scope.listaOpAnalise = ['Aprovado - Finalizado', 'Em analise - Em analise', 'Recusado pela Analise de Risco - Finalizado', 'Pendente'];
    		   
    	   } else if(angular.equals(tipo, 'too')){
    		   $scope.dadosAnalise = {analise: registro.processo_too, 
													situacao: registro.situacao_analise_too,
													dataAprovacao : dataUtil.isDataValida(registro.data_aprovacao_too) ? dataUtil.formatarData(registro.data_aprovacao_too) : dataUtil.getDataAtual()};
    		   
    		   $scope.listaOpAnalise = ['Análise cadastral aprovada', 'Em Análise Pela Companhia', 'Análise cadastral reprovada', 'Pendente'];
    	   }
    	   
    	   $scope.dadosAnalise.codigoCadastro = registro.codigo;
    	   $scope.dadosAnalise.tipoSeg = tipo;
    	   
    	   $scope.primeiraOpSituacao = ['Análise cadastral aprovada', 'Aprovado - Finalizado'];
    	      
       }
       
      var enviaEmails = function(codigo = '') {
           	$.ajax({
					type: "POST", 
					url: "https://www.segurosja.com.br/gerenciador/fianca/app/php/email_status_propostas.php",
					dataType: "json",           
                  data:{
                      codigo:codigo 
                  },
					success: function(response) {
                         console.log('sucess: '+response);        
					}
				}); 
		};

       //retorna o nome da seguradora pelo código
       $scope.getNomeSeguradora = function(registro){
    	if($scope.listaSeguradoras){
    		var seguradora = $scope.listaSeguradoras.filter(i=> i.sigla == registro.seguradora)[0];
    		if(seguradora){
    			return seguradora.sigla + '-' + seguradora.nome_abrev;
    		}
    	}else{
    		return '';
    	}
      }
       
       $scope.getDescricaoFormaPagamento = function(registro){
    	   var codigo = registro.forma_pagto;
    	   if(isCodigoPlanoLiberty(codigo)){
     		  return service.formatarValor(registro.premio_total) +  (" (mensais) - Plano: " + obterDescricaoPlanoLiberty(codigo.split('_')[1]));
     		   
     	   }else if($scope.listaFormasPgtoPorto && $scope.listaFormasPgtoPorto.length > 0){
     		  var formaPgto =  $scope.listaFormasPgtoPorto.filter(fp=> parseInt(registro.forma_pagto) == parseInt(fp.codigo_porto))[0];
     		  if(formaPgto){
     			 return formaPgto.descricao + (angular.equals(formaPgto.grupo, 'CARTAO_CREDITO_RECORRENTE') ? '  (Recorrência)' : '');
     		  }
     	  }
    	   return "";
        }
       
       var obterDescricaoPlanoLiberty = function(plano){
    	   switch (plano.toUpperCase()) {
			case 'B1': return 'Básico (Sem desconto por seguro incêndio)'; break
			case 'C1': return 'Completo (Sem desconto por seguro incêndio)'; break
			case 'B2': return 'Básico (COM desconto por seguro incêndio)'; break
			case 'C2': return 'Completo (COM desconto por seguro incêndio)'; break
			}
       }
       
       var isCodigoPlanoLiberty = function(codigo){
    	   var codArr = codigo.split('_');
    	   if(codArr.length > 1){
    		   return ['B1','C1','B2','C2'].includes(codArr[1]);
    	   }
    	   return false;
       }
       
       $scope.obterIndeceReajustePorCodigo = function(codigo){
    	   switch (codigo) {
		case '1': return 'IGP - M (FGV)';
		case '2': return ' IGP - DI (FGV)';
		case '3': return 'IPC - (FIPE)';
		case '4': return 'IPCA - (IBGE)';
		case '5': return ' INPC - (IBGE)';
		case '6': return 'ICV - (DIEESE)';
		case '7': return 'INCC';
		case '8': return 'IPC - FGV';
		case '9': return 'Maior Índice';
		default: return '';
		}
       }
       
       $scope.calcularPeriodo = function(registro, esconderDiasNosMeses){
    	   if(registro.inicio && registro.fim_contrato){
    		   var dias = dataUtil.difEntreDatasEmDias(registro.inicio, registro.fim_contrato);
    		   var periodoEmMeses = dias/30;
    		   var regex = new RegExp('^-?\\d+(?:\.\\d{0,' + (0 || -1) + '})?');
    		   var resultado = periodoEmMeses.toString().match(regex)[0];
    		   var diasRestantes = dias - (parseInt(resultado) * 30);
    		   var retorno = parseInt(resultado) > 1 ?  (resultado + ' Meses ') : (resultado + ' Mes ');
    		   
    		   if(retorno && esconderDiasNosMeses){
    			   return retorno;//exibe so os meses sem os dias
    		   }
    		   
    		   if(diasRestantes > 0){
    			   retorno += 'e ';
    			   retorno += diasRestantes > 1 ? (diasRestantes + ' dias') : (diasRestantes + ' dia');
    		   }
    		   return retorno;
    	   }
       }
       
       /**
		 * Retorna a descrição do estado civil
		 */
		$scope.getDescEstadoCivil = function(codigo){
			switch (codigo) {
			case "0": return "Solteiro(a)";
			case "1": return "Casado(a)";
			case "2": return "Divorciado(a)";
			case "3": return "Viúvo(a)";
			case "4": return "Separado(a)";
			case "5": return "Companheiro(a)";
		  }
		}
       

       $scope.irParaListagem();
       listar();
       ativarRefresh();
       
       
       if(isIncluirParam === "true"){
    	   $scope.incluirRegistro();
       }
    }]);