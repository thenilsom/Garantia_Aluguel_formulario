 angular
       .module('app')
       .controller('MainController', ['$scope', 'serviceUtil', 'validaService', 'FileUploader', 
        function($scope, service, validador, FileUploader){

               
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

          $scope.passo = '1';
          $scope.uploader = new FileUploader({
            url : 'upload.php'
          });
          $scope.cadastro = {};


          $scope.proximoPasso = function(){    
            $scope.passo = service.obterProximoPasso($scope.passo);
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

              if($scope.errors.length == 0){
                $scope.proximoPasso();
              }else{
                setTimeout(function(){
                  $scope.goTo('listErrors');
                });
                
              }
          }


          $scope.getTotal = function(obj){
            if(service.isNullOrEmpty(obj)) return 0;
            return service.valorOuZeroSeNull(obj.aluguel) +
                   service.valorOuZeroSeNull(obj.iptu) +
                   service.valorOuZeroSeNull(obj.condominio) +
                   service.valorOuZeroSeNull(obj.agua) +
                   service.valorOuZeroSeNull(obj.luz) +
                   service.valorOuZeroSeNull(obj.gas);
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
    }]);