angular.module('app')
.factory('validaService', ['serviceUtil', function(util){

		var service = {};

		service.validarCamposObrigatorios = function(formName, errors){
			$("form[name = '"+formName+"'] [requerido]").each(function(){
				if($(this).val() == undefined || $(this).val().trim().length == 0 || $(this).val().startsWith('?')){
					var label = $("label[for='"+$(this).attr('id')+"']").text().replace('*', '');
					var descErro = label + " obrigatório.";
					
					if(!errors.includes(descErro))
						errors.push(descErro);
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

  service.validarCNPJ = function(cnpj) {
 
    cnpj = cnpj.replace(/[^\d]+/g,'');
 
    if(cnpj == '') return false;
     
    if (cnpj.length != 14)
        return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
    
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
	
	/**
	 * retorna true se o ddd for valido
	 */
	service.isDDDValido = function(ddd){
		return ddd && ddd.length == 2;
	}
	
	/**
	 * Valida o tipo de dados nos campos
	 */
	service.validarTipoDados = function(formName, errors){
		validarCamposMonetario(formName, errors);
		//validarCamposCpf(formName, errors);
		//validarCamposCnpj(formName, errors);
		validarCamposData(formName, errors);
		validarCamposCep(formName, errors);
	}
	
	var validarCamposMonetario = function(formName, errors){
		$("form[name = '"+formName+"'] [valida-monetario]").each(function(){
			if($(this).val() && $(this).val() != undefined && $(this).val().trim().length > 0){
				if(!isCampoMonetarioValido($(this).val())){
					adicionarErro(errors, $(this).attr('id'), " com formato de valor inválido. Ex formatos válidos = 100,00 | 1.000,00 | 10.500,00");
				}
			}
		});
	}
	
	var validarCamposCpf = function(formName, errors){
		$("form[name = '"+formName+"'] [valida-cpf]").each(function(){
			if($(this).val() && $(this).val() != undefined && $(this).val().trim().length > 0){
				if(!isCampoCpfCnpjValido($(this).val())){
					adicionarErro(errors, $(this).attr('id'), " com formato inválido. Ex formato válido = 000.000.000-00");
				}
			}
		});
	}
	
	var validarCamposCnpj = function(formName, errors){
		$("form[name = '"+formName+"'] [valida-cnpj]").each(function(){
			if($(this).val() && $(this).val() != undefined && $(this).val().trim().length > 0){
				if(!isCampoCpfCnpjValido($(this).val())){
					adicionarErro(errors, $(this).attr('id'), " com formato inválido. Ex formato válido = 00.000.000/0000-00");
				}
			}
		});
	}
	
	var validarCamposData = function(formName, errors){
		$("form[name = '"+formName+"'] [valida-data]").each(function(){
			if($(this).val() && $(this).val() != undefined && $(this).val().trim().length > 0){
				if(!isCampoDataValido($(this).val())){
					adicionarErro(errors, $(this).attr('id'), " com formato inválido. Ex formato válido = 01/01/2021");
				}
			}
		});
	}
	
	var validarCamposCep = function(formName, errors){
		$("form[name = '"+formName+"'] [valida-cep]").each(function(){
			if($(this).val() && $(this).val() != undefined && $(this).val().trim().length > 0){
				if(!isCampoCepValido($(this).val())){
					adicionarErro(errors, $(this).attr('id'), " com formato inválido. Ex formato válido = 99.999-99");
				}
			}
		});
	}
	
	/**
	 * Adiciona o erro na lista
	 */
	var adicionarErro = function(errors, idInput, msg){
		var label = $("label[for='"+idInput+"']").text().replace('*', '');
		var descErro = label + msg;
		if(!errors.includes(descErro)){
			errors.push(descErro);
		}
	}
	
	/**
	 * Valida campos Monetario pt_br
	 */
	var isCampoMonetarioValido = function(valor){
		var valorString = valor + '';
		if(valorString.indexOf(',') == -1){
			return false;
		}
		var valorFinal = 'R$' + valor;
		 return /^R\$(\d{1,3}(\.\d{3})*|\d+)(\,\d{2})?$/.test(valorFinal);
	}
	
	/**
	 * Valida o formato do campo cpf/cnpj
	 */
	var isCampoCpfCnpjValido = function(valor){
		 return /(^\d{3}\.\d{3}\.\d{3}\-\d{2}$)|(^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$)/.test(valor);
	}
	
	/**
	 * Valida o formato do campo Data no padrão dd/mm/yyyy
	 */
	var isCampoDataValido = function(valor){
		 return /(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)/.test(valor);
	}
	
	/**
	 * Valida o formato do campo cep
	 */
	var isCampoCepValido = function(valor){
		return /^[0-9]{2}.[0-9]{3}-[0-9]{3}$/.test(valor);
	}
	
	return service;
}]);
