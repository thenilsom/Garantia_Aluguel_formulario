angular.module('app')
.factory('validaService', ['serviceUtil', function(util){

		var service = {};

		service.validarCamposObrigatorios = function(formName, errors){
			$("form[name = '"+formName+"'] [requerido]").each(function(){
				if($(this).val() == undefined || $(this).val().trim().length == 0 || $(this).val().startsWith('?')){
					var label = $("label[for='"+$(this).attr('id')+"']").text().replace('*', '');
					errors.push(label + " obrigatório.");
				}
			});
		}

	service.validarCpf = function(cpf){
		 // Remove caracteres inválidos do valor
	    cpf = !util.isNull(cpf) ? cpf.replace(/[^0-9]/g, '') : '';
	    
		if(util.isNullOrEmpty(cpf)) return true;
		// Garante que o valor é uma string
	    cpf = cpf.toString();
	    
	    var numeros, digitos, soma, i, resultado, digitos_iguais;
	    digitos_iguais = 1;
	    if (cpf.length < 11)
	          return false;
	    for (i = 0; i < cpf.length - 1; i++)
	          if (cpf.charAt(i) != cpf.charAt(i + 1))
	                {
	                digitos_iguais = 0;
	                break;
	                }
	    if (!digitos_iguais)
	          {
	          numeros = cpf.substring(0,9);
	          digitos = cpf.substring(9);
	          soma = 0;
	          for (i = 10; i > 1; i--)
	                soma += numeros.charAt(10 - i) * i;
	          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	          if (resultado != digitos.charAt(0))
	                return false;
	          numeros = cpf.substring(0,10);
	          soma = 0;
	          for (i = 11; i > 1; i--)
	                soma += numeros.charAt(11 - i) * i;
	          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	          if (resultado != digitos.charAt(1))
	                return false;
	          return true;
	          }
	    else
	        return false;
  }
	
	
	service.validarEmail = function(email){
		 var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	   
		if(email === undefined || email.trim().length === 0) {
				return true;
		} else {
			if(!emailRegex.test(email)){
				return false;
			}
			return true;
		}		
	}

	//validação de caracteres especiais
	service.validarCaracteresEspeciais = function(texto){
		var regex = '[^a-z A-Z]+';
  		if(texto.match(regex)) {
       //encontrou então não passa na validação
		return false;
 		 }
  		else {
       //não encontrou caracteres especiais
		return true;
		  }
		}

		
	return service;
}]);
