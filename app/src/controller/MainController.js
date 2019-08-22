 angular
       .module('app')
       .controller('MainController', ['$scope', '$http', 'serviceUtil', 'formularioService', 'validaService', 'FileUploader', 
        function($scope, $http, service, formularioService, validador, FileUploader){

        //obtem os parametros na url se existir
        var paramUrl = service.extraiParamUrl(location.search.slice(1));

          //controla o hide/show do botão ir para topo quando chegar no fim da pagina
        $(window).scroll(function () {
          //usar esse if para exibir o btn ir para o top quando o usuario rolar a pagina
          //if ($(this).scrollTop() > 100); 

          var maxTop = document.body.scrollHeight - (document.body.clientHeight + 300);
           if (parseInt($(this).scrollTop()) >= maxTop) {
            $('.btn-go-top').addClass('display').fadeIn();
           } else {
            $('.btn-go-top').removeClass('display').fadeOut();
           }
        });
          
          /*Função voltar para o topo da pagina*/
          $scope.gotoTop = function(){
            $("html, body").animate({ scrollTop: 0 }, 300);
          }

          /*rola a pagina até o id passado*/
          $scope.goTo = function(id){
           service.moveTo(id);
          }

          /*************************FUNÇÕES DO FORMULÁRIO**********************/
          $scope.errors = [];
          var passosValidados = [];
          $scope.passo = '1';

          $scope.cadastro = {};
          $scope.cadastro.imobiliaria = {};
          $scope.cadastro.pretendente = {nacionalidade: 'Brasileiro(a)'};
          $scope.cadastro.residencia = {};
          $scope.cadastro.profissional = {};
          $scope.cadastro.imovel = {};
          $scope.cadastro.pessoal = {tipoPessoa : 'FISICA'};
          
          if(paramUrl){
            var cpfCnpjParam = service.formatarCpfCnpj(service.decriptografar(paramUrl.var1));
            $http.post('../app/php/consulta.php/consultarCpfCnpj', {cpfCnpj : cpfCnpjParam}).then(function(data){
            var dadosImobiliaria = service.extraiParamUrl(data.data);
            $scope.cadastro.imobiliaria.fantasia = dadosImobiliaria.fantasia;
            $scope.cadastro.imobiliaria.razao = dadosImobiliaria.razao;
            $scope.cadastro.imobiliaria.corretor = dadosImobiliaria.corretor;
            $scope.cadastro.imobiliaria.cnpj = cpfCnpjParam;
             
             $scope.cadastro.imovel.aluguel = service.formatarValor(service.decriptografar(paramUrl.var2));
             $scope.cadastro.imovel.condominio = service.formatarValor(service.decriptografar(paramUrl.var3));
             $scope.cadastro.imovel.iptu = service.formatarValor(service.decriptografar(paramUrl.var4));
             $scope.cadastro.imovel.agua = service.formatarValor(service.decriptografar(paramUrl.var5));
             $scope.cadastro.imovel.luz = service.formatarValor(service.decriptografar(paramUrl.var6));
             $scope.cadastro.imovel.gas = service.formatarValor(service.decriptografar(paramUrl.var7));
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
          }

          /*inicia as configurações de upload*/
          var iniciarUpload = function(id_codigo){
            $scope.uploader = new FileUploader({
              url : '../app/php/upload.php',
              formData:[{codigo: id_codigo}]
            });

             /*Envia o upload dos arquivos*/
          $scope.enviarArquivos = function(){
            var listaTipoNaoInformado = $scope.uploader.queue
                                          .filter(item=> !item.isUploaded)
                                          .filter(item=> !item.file.tipoDoc || 
                                          angular.equals(item.file.tipoDoc, 'outros') && !item.file.descOutros);

            if(listaTipoNaoInformado.length > 0){
              service.alertar('Informe o tipo do documento.');

            }else{
                $scope.uploader.queue.forEach(function(item, index){
                var arrayName = item.file.name.split('.');
                var extensao = '.' + arrayName[arrayName.length - 1];

                if(angular.equals(item.file.tipoDoc, 'outros')){
                  item.file.name = (index + 1) + '-' + item.file.descOutros + extensao;
                }else{
                  item.file.name = (index + 1) + '-' + item.file.tipoDoc + extensao;
                }
              });

              $scope.uploader.uploadAll();
            }
            
          }


           /*função chamada em caso de erro no upload*/
          $scope.uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
            service.alertarErro(response);
          };

          $scope.uploader.onCompleteAll = function() {
            service.alertar('Arquivos enviados com sucesso!');
          };
        } 

        //########### TESTE ALTERAÇÃO NO FORMULARIO ##########################
        var testarAlteracao = function(){
          var codigoParam = null;
          $http.post('http://www.segurosja.com.br/gerenciador/fianca/app/php/consulta.php/consultarPorCpfInquilino', {cpf: '026.715.341-40'}).then(function(data){
            $scope.cadastro = formularioService.preencherFormulario(data.data[0]);
            $scope.isAlteracao = true;
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
        }

        testarAlteracao();         
        //######################################################################




          /** Submete o formulario ao PHP*/
          $scope.salvar = function(){
            //garante a formatação do cpf
            $scope.cadastro.pretendente.cpf = service.formatarCpfCnpj($scope.cadastro.pretendente.cpf);

            $http.post('../app/php/api.php/salvarFormulario', $scope.cadastro).then(function(data){
              $scope.codigoCadastro = data.data;
              service.exibirAlertaCadastro();
              iniciarUpload(data.data);
              $scope.proximoPasso();
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
          }
        
          var setarPasso = function(passo){
            $scope.passo = passo;
          }

          var isPassoValidado = function(passo){
            return passosValidados.indexOf(passo) > -1;
          }

          $scope.proximoPasso = function(){
            if($scope.errors.length == 0){
               if(!isPassoValidado($scope.passo))
                passosValidados.push($scope.passo);

               setarPasso(service.obterProximoPasso($scope.passo));
               
              }else{
                if(isPassoValidado($scope.passo))
                  passosValidados.splice(passosValidados.indexOf($scope.passo), 1);
                
                setTimeout(function(){
                  $scope.goTo('listErrors');
                });
                
              }
          }

          //navega entre as abas
          $scope.navegarAbas = function(passo){
            if($scope.isAlteracao){
              setarPasso(passo);

            }else{
              var passoAtual = parseInt($scope.passo)
              var passoPretendido = parseInt(passo)
              if(passoAtual > passoPretendido || 
                  (isPassoValidado(passoAtual.toString()) && (passoAtual + 1) == passoPretendido)){
                setarPasso(passo);

              }else{
                var validado = true;
                for (var i = 1; i < parseInt(passo); i++) {
                    if(!isPassoValidado(i.toString())){
                      service.alertarErro('Preencha os dados obrigatorios das abas anteriores.');
                      validado = false;
                      break;
                    }
                  }

                if(validado)
                  setarPasso(passo);
              }
            }   
          }

          $scope.passoAnterior = function(){
           $scope.passo = service.obterPassoAnterior($scope.passo);
          }

          $scope.getLabelEtapa = function(etapa){
            return service.labelEtapa(etapa);
          }

          /*Valida os dados do Pretendente*/
          $scope.validarDadosPretendente = function(form){
             $scope.errors = [];
             validador.validarCamposObrigatorios(form, $scope.errors);
              if(!validador.validarCpf($scope.cadastro.pretendente.cpf)){
                $scope.errors.push("CPF inválido");
              }

              if(!validador.validarCpf($scope.cadastro.pretendente.cpfConjuge)){
                $scope.errors.push("CPF Conjuge inválido");
              }

              if(!validador.validarEmail($scope.cadastro.pretendente.email)){
                $scope.errors.push("EMAIL inválido");
              }

              if(!$scope.cadastro.pretendente.telefone && !$scope.cadastro.pretendente.celular
                && !$scope.cadastro.pretendente.telefoneComercial){
                $scope.errors.push("Preencha ao menos um campo de telefone.");
              }

              if(!validador.validarCaracteresEspeciais($scope.cadastro.pretendente.nome)){
                $scope.errors.push("Nome do pretendente não pode conter acentos ou caracteres especiais.");
              }

              //se tiver sido informado telefone comercial seta no tel da empresa
              if($scope.cadastro.pretendente.telefoneComercial)
                  $scope.cadastro.profissional.telefone = $scope.cadastro.pretendente.telefoneComercial

              $scope.proximoPasso();
          }

          /*valida os dados profissionaiss*/
          $scope.validarDadosProfissionais = function(form){
            $scope.errors = [];
             validador.validarCamposObrigatorios(form, $scope.errors);

            if($scope.cadastro.profissional.outrosRendimentos && 
              !parseFloat($scope.cadastro.profissional.totalRendimentos) > 0)
              $scope.errors.push("Informe o total dos outros rendimentos.");

            $scope.proximoPasso();
          }

          /*Valida os dados do imóvel*/
          $scope.validarDadosDoImovel = function(form){
            $scope.errors = [];
            validador.validarCamposObrigatorios(form, $scope.errors);

            if($scope.cadastro.imovel.cnpjEmpresaConstituida && !validador.validarCNPJ($scope.cadastro.imovel.cnpjEmpresaConstituida)){
                $scope.errors.push("CNPJ empresa constituída inválido");
              }

              $scope.proximoPasso();

          }

          /*Valida os dados obrigatorios*/
          $scope.validarDadosObrigatorios = function(form){
             $scope.errors = [];
             validador.validarCamposObrigatorios(form, $scope.errors);
             $scope.proximoPasso();
          }


          $scope.getTotalGastosMensais = function(){
            if(service.isNull($scope.cadastro.imovel)) return 0;
            return service.valorOuZeroSeNull($scope.cadastro.imovel.aluguel) +
                   service.valorOuZeroSeNull($scope.cadastro.imovel.iptu) +
                   service.valorOuZeroSeNull($scope.cadastro.imovel.condominio) +
                   service.valorOuZeroSeNull($scope.cadastro.imovel.agua) +
                   service.valorOuZeroSeNull($scope.cadastro.imovel.luz) +
                   service.valorOuZeroSeNull($scope.cadastro.imovel.gas);
          }

          $scope.getRendaNecessaria = function(){
            if(angular.equals($scope.cadastro.imovel.finalidade, 'RESIDENCIAL'))
                return $scope.getTotalGastosMensais() / 0.35;

              return $scope.getTotalGastosMensais() / 0.15;
          }

          $scope.getRendaInformada = function(){
            return service.valorOuZeroSeNull($scope.cadastro.profissional.salario) +
                   service.valorOuZeroSeNull($scope.cadastro.profissional.totalRendimentos);
          }

          $scope.isRendaSuficiente = function(){
            return $scope.getRendaInformada() >= $scope.getRendaNecessaria();
          }

          $scope.pesquisarCep = function(obj){
            //se o cep for valido efetua a consulta no webservice
            var cep = obj.cep.replace(/\.|\-/g, '');
            if(/^[0-9]{8}$/.test(cep)){
              service.consultarCep(cep, function(dados){
                if(dados !== null){
                  obj.estado = dados.uf;
                  obj.cidade = dados.localidade.toUpperCase();
                  obj.endereco = dados.logradouro.toUpperCase();
                  obj.bairro = dados.bairro.toUpperCase();
                  obj.complemento = dados.complemento.toUpperCase();
                  $scope.$digest();
                }
              })
            }
          }

          $scope.alertaLocatarioSolidario = function(){
            if(angular.equals($scope.cadastro.pessoal.possuiRendaArcarLocacao, 'N')){
              service.alertar('Informe a quantidade de pessoas que comporão renda com o Pretendente.');
            }
            
          }
    }]);