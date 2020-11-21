angular.module('app')
.factory('dataUtil', ['$filter', function($filter){

		var service = {};

	//recebe no padrao: 2019-10-18 retorna no padrão dd/MM/yyyy
	service.formatarDataServidor = function(dataServidor){
		var data = dataServidor.split('-');
		return data[2] + '/' + data[1] + '/' + data[0];
	}

	//recebe no padrao: dd/MM/yyyy retorna no padrão 2019-10-18 
	service.formatarParaDataServidor = function(dataParaServidor){
		if(dataParaServidor){
			var data = dataParaServidor.split('/');
			return data[2] + '-' + data[1] + '-' + data[0];
		}
		return dataParaServidor;
	}

	//retorna a data atual no padrão dd/MM/yyyy
	service.getDataAtual = function(){
		 var data = new Date(),
	        dia  = data.getDate().toString(),
	        diaF = (dia.length == 1) ? '0'+dia : dia,
	        mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
	        mesF = (mes.length == 1) ? '0'+mes : mes,
	        anoF = data.getFullYear();
	    return diaF+"/"+mesF+"/"+anoF;
	}

	service.formatarData = function(data){
	 return $filter('date')(data, 'dd/MM/yyyy', 'UTC');
	}
	

	service.getHoraAtual = function(){
		var agora = new Date();
		return agora.getHours() + ':' + agora.getMinutes();
	}
	
	service.isDataValida = function(data){
		return data && !data.startsWith('0000-00-00');
	}
		
	//cria uma data hora. os parametros deve ser no pardrão : '2019-09-20' '20:37:37'
	service.criarDataHora = function(data, hora){
		var dataArray = data.split('-');
		var horaArray = hora.split(':');

		return new Date(dataArray[0], parseInt(dataArray[1]) - 1, dataArray[2], horaArray[0], horaArray[1], horaArray[2]);
	}
	
	//retorna true se a data passada estiver a mais de 30 minutos da data atual
	service.isDifHoraMais30minutos = function(data){
		var agora = new Date();
	
		if(agora.getDate() > data.getDate() || agora.getMonth() > data.getMonth() || agora.getYear() > data.getYear())
			return true;
		
		var dif = ((agora.getHours() * 60) + agora.getMinutes()) - ((data.getHours() * 60) + data.getMinutes());
		
		return dif > 30;
		
	}
	
	 /**
 	 * Retorna a diferença entre datas em dias
 	 */
 	service.difEntreDatasEmDias = function(dataInicio, dataFim){
 		dataInicio = service.formatarData(dataInicio);
 		dataFim = service.formatarData(dataFim);
 		var arrayDI = dataInicio.split('/');
 		var arrayDF = dataFim.split('/');
		dataInicio =  new Date(arrayDI[2], parseInt(arrayDI[1]) - 1, arrayDI[0]);
		dataFim =  new Date(arrayDF[2], parseInt(arrayDF[1]) - 1, arrayDF[0]);
		
 		var diff = Math.abs(dataInicio.getTime() - dataFim.getTime());
 		var days = Math.ceil(diff / (1000 * 60 * 60 * 24));
 		return days;
     };
     
     service.difEntreDatasEmAnos = function(dataInicio, dataFim){
  		dataInicio = service.formatarData(dataInicio);
  		dataFim = service.formatarData(dataFim);
  		var arrayDI = dataInicio.split('/');
  		var arrayDF = dataFim.split('/');
 		dataInicio =  new Date(arrayDI[2], parseInt(arrayDI[1]) - 1, arrayDI[0]);
 		dataFim =  new Date(arrayDF[2], parseInt(arrayDF[1]) - 1, arrayDF[0]);
 		return dataFim.getFullYear() - dataInicio.getFullYear();
      };

	return service;
}]);
