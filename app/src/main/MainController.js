 angular
       .module('app')
       .controller('MainController', ['$scope', '$http', 'serviceUtil', 'validaService', 'FileUploader', 
        function($scope, $http, service, validador, FileUploader){

        //obtem os parametros na url se existir
        var paramUrl = service.extraiParamUrl();

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
          $scope.passo = '1';

          $scope.cadastro = {};
          $scope.cadastro.pretendente = {nacionalidade: 'Brasileiro(a)'};
          $scope.cadastro.residencia = {};
          $scope.cadastro.profissional = {};
          $scope.cadastro.imovel = {};
          $scope.cadastro.pessoal = {tipoPessoa : 'FISICA'};

          if(paramUrl){
            var cpfCnpjParam = service.formatarCpfCnpj(paramUrl.var1);
            $http.post('../app/php/consulta.php/consultarCpfCnpj', {cpfCnpj : cpfCnpjParam}).then(function(data){
             $scope.cadastro.pretendente.nome = data.data;
             $scope.cadastro.imovel.aluguel = service.formatarValor(paramUrl.var2);
             $scope.cadastro.imovel.condominio = service.formatarValor(paramUrl.var3);
             $scope.cadastro.imovel.iptu = service.formatarValor(paramUrl.var4);
             $scope.cadastro.imovel.agua = service.formatarValor(paramUrl.var5);
             $scope.cadastro.imovel.luz = service.formatarValor(paramUrl.var6);
             $scope.cadastro.imovel.gas = service.formatarValor(paramUrl.var7);
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

           /*função chamada em caso de erro no upload*/
          $scope.uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
            service.alertarErro(response);
          };

          $scope.uploader.onCompleteAll = function() {
            service.alertar('Arquivos enviados com sucesso!');
          };
        }          

          /** Submete o formulario ao PHP*/
          $scope.salvar = function(){
            $http.post('../app/php/api.php/salvarFormulario', $scope.cadastro).then(function(data){
              service.alertar('Cadastro: ' + data.data + ' Gravado !');
              iniciarUpload(data.data);
              $scope.proximoPasso();
            }, function(erro){
              service.alertarErro(erro.statusText);
            });
          }
        

          $scope.proximoPasso = function(){
            if($scope.errors.length == 0){
               $scope.passo = service.obterProximoPasso($scope.passo);
              }else{
                setTimeout(function(){
                  $scope.goTo('listErrors');
                });
                
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
            if(angular.equals($scope.cadastro.pessoal.possuiRendaArcarLocacao, 'nao')){
              service.alertar('Informe a quantidade de pessoas que comporão renda com o Pretendente.');
            }
            
          }
    }]);