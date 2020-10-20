/*
 * Message.Service.jsa
 * Copyright (c) AutoCom Sistemas.
 * 
 * Este software é confidencial e propriedade da AutoCom Sistemas.
 * Não é permitida sua distribuição ou divulgação do seu conteúdo sem expressa autorização da AutoCom Sistemas.
 * Este arquivo contém informações proprietárias.
 * 
 * @author Samuel Oliveira.
 */
angular.module('app').constant('TIPO',{
	ALERTA:'alert-warning',
	CONFIRMACAO:'alert-info',
	ERRO:'alert-danger',
	INFORMACAO:'alert-info'
}).factory('messageUtil', ['$confirm', '$message', '$timeout', 'TIPO', function($confirm, $message, $timeout, TIPO) {
	
	var message = {};
	var $modelConfirm = new $confirm();
	var MSG001 = "Operação realizada com sucesso.";
	var MSG002 = "Nenhum resultado obtido.";
	var MSG003 = "Usuário sem permissão.";
	var MSG004 = "Possui caracteres especiais inválidos. São aceitos apenas (ponto(.) virgula(,) traço(-) barra(/) e &)";
	
	//Constantes para label
	var LABEL_ALERT = 'Alerta!';
	var LABEL_INFO = 'Informação!';
	var LABEL_ERROR = 'Erro!';

	
	/**
	 * Exibe uma mensagem de sucesso do tipo show/hide
	 */
	message.addMsgInf = function(msg){
		$message.addMsgInf(msg);
    };
	
	/**
	 * Exibe uma mensagem padrão de sucesso do tipo show/hide
	 */
	message.addMsgInfPadrao = function(){
		$message.addMsgInf(MSG001);
    };
	
	/***
	 * Exibe uma mensagem de alerta informado que não houve resultado
	 * na pesquisa.
	 */
	message.showAlertNotResult = function(elementId){
		message.showAlert(MSG002, elementId);
    };
	
	/**
	 * Exibe uma mensagem de alerta de sem permissão
	 */
	message.showAlertNoPermission = function(){
		message.showAlert(MSG003);
    };
    
    
    /**
     * Exibe uma mensagem de alerta de caracteres especiais
     */
    message.showAlertCaracterEspecial = function(campo, elementId){
    	message.showAlert(campo + ' ' + MSG004, elementId);
    }
	
	/**
	 * Exibe uma mensagem de alerta
	 */
	message.showAlert = function(externMsg, elementId){
		showMessage(externMsg, LABEL_ALERT, TIPO.ALERTA, function(){
			setarFocus(elementId);
		});
    };
	
	/**
	 * Exibe uma mensagem de erro
	 * Obs: se a mensagem for do tipo Sistema: exibe um alerta
	 */
	message.showError = function(externMsg, elementId){
		if(externMsg && externMsg.includes('Sistema:')){
			message.showAlert(externMsg.replace('Sistema:', ''), elementId);
			
		}else{
			//se mensagem vier nulo seta como erro ao conectar ao servidor
			if(!externMsg) externMsg = 'Erro ao conectar ao servidor.';
			showMessage(externMsg, LABEL_ERROR, TIPO.ERRO, function(){
				setarFocus(elementId);
			});
		}
    };
	
	/**
	 * Exibe uma mensagem de informação
	 */
	message.showInfo = function(externMsg, elementId, ignorarAlertAtivo){
		showMessage(externMsg, LABEL_INFO, TIPO.INFORMACAO, function(){
			setarFocus(elementId);
		}, ignorarAlertAtivo);
    };
	
	/**
	 * Exibe uma mensagem de confirmação
	 * externMsg : mensagem a ser exibida
	 * callbackYes: função a ser executada em caso de confirmação.
	 * callbackNo: função a ser executada em caso de não confirmação.
	 */
	message.showConfirm = function(externMsg, callbackYes, callbackNo, ignorarAlertAtivo){
		if(!message.isAlertAtivo(ignorarAlertAtivo)){
			if(typeof callbackNo === 'function'){
				$modelConfirm.addConfirm({msg: externMsg, tipo: TIPO.CONFIRMACAO, actionYes : callbackYes, actionNo: callbackNo});
			}else{
				$modelConfirm.addConfirm({msg: externMsg, tipo: TIPO.CONFIRMACAO, actionYes : callbackYes});
			}
		}
    };
	
	/**
	 * Exibe uma mensagem de confirmação padrão de cancelamento
	 * callbackYes: função a ser chamda ao confirmar o cancelamento.
	 */
	message.showConfirmCancel = function(callbackYes){
		if(!message.isAlertAtivo()){
			message.showConfirm('Deseja sair da operação?', callbackYes);
		}
    };
    
    /**
     * Exibe uma mensagem de confirmação para sair do sistema
     * callbackYes: função a ser chamda ao confirmar.
     */
    message.showConfirmSairSistema = function(callbackYes){
		if(!message.isAlertAtivo()){
			message.showConfirm('Deseja realmente sair do sistema?', callbackYes);
		}
    };
	
	/**
	 * Exibe o modal de confirmação e ao clicar em 'OK' redireciona para a tela
	 * principal do programa.
	 */
	message.confirmarEretornarParaTelaPrincipal = function(externMsg){
		showMessage(externMsg, LABEL_INFO, TIPO.INFORMACAO, function(){
			voltarParaPrincipal();
		});
    };
	
	/**
	 * Exibe o modal de ALERTA e ao clicar em 'OK' redireciona para a tela
	 * principal do programa.
	 */
	message.alertarEretornarParaTelaPrincipal = function(externMsg){
		showMessage(externMsg, LABEL_ALERT, TIPO.ALERTA, function(){
			voltarParaPrincipal();
		});
    };
	
	/**
	 * Exibe um alerta de informação invocando a função de callback passada como parametro
	 * ao clicar em ok
	 */
	message.showInfoWithAction = function(externMsg, callbackOk){
		showMessage(externMsg, LABEL_INFO, TIPO.INFORMACAO, callbackOk);
    };
    
    /**
	 * Exibe um alerta de informação invocando a função de callback passada como parametro
	 * ao clicar em ok e ignorando se já existe um outro alert ativo na tela
	 */
	message.showInfoWithActionIgnoreAlert = function(externMsg, callbackOk){
		exibirConfirm(externMsg, LABEL_INFO, TIPO.INFORMACAO, callbackOk);
    };
    
    /**
	 * Exibe um alerta invocando a função de callback passada como parametro
	 * ao clicar em ok
	 */
	message.showAlertWithAction = function(externMsg, callbackOk, ignorarAlertAtivo){
		showMessage(externMsg, LABEL_ALERT, TIPO.ALERTA, callbackOk, ignorarAlertAtivo);
    };
    
    /**
	 * Exibe um erro invocando a função de callback passada como parametro
	 * ao clicar em ok
	 */
	message.showErrorWithAction = function(externMsg, callbackOk){
		showMessage(externMsg, LABEL_ERROR, TIPO.ERRO, callbackOk);
    };
	
	/**
	 * Retorna true se o alerta já estiver ativo
	 */
	message.isAlertAtivo = function(ignorarAlertAtivo){
		if(ignorarAlertAtivo){
			return false;
		}
		return $('#okConfirm').is(':visible');
    };
    
    /**
     * Força o click no modal ativo para fechalo
     */
    message.fecharAlertAtivo = function(){
    	$('#okConfirm').click();
    }
	
	/**
	 * Adiciona uma mensagem de acordo com o tipo informado
	 * externMsg: A mensagem a ser exibida
	 * title: O titulo da mensagem
	 * type: o tipo da mensagem
	 * callbackOk: função a ser invocada ao clicar em ok
	 */	
	var showMessage = function(externMsg, title, type, callbackOk, ignorarAlertAtivo){
		if(!message.isAlertAtivo(ignorarAlertAtivo)){
			exibirConfirm(externMsg, title, type, callbackOk);
		}
    };
    
    /**
	 * Adiciona uma mensagem de acordo com o tipo informado
	 * externMsg: A mensagem a ser exibida
	 * title: O titulo da mensagem
	 * type: o tipo da mensagem
	 * callbackOk: função a ser invocada ao clicar em ok
	 */	
	var exibirConfirm = function(externMsg, title, type, callbackOk){
			$modelConfirm.addConfirm({
				msg		: externMsg ? externMsg : '--',
				titulo   : title,
				tipo 		: type,
				actionOk : callbackOk
			});
    };
	
	/**
	 * seta o foco no elemento informado.
	 */
	var setarFocus = function(elementId){
		if(!isEmpty(elementId)) {
			var field = document.getElementById(elementId);	
				if(!isEmpty(field)){
					setTimeout( function() {
						field.focus();
						if(field.type == 'text') field.select();
					})
				}
			}
    };
	
	/**
	 * Retorna true se o objeto passado for null ou undefined
	 */
	var isEmpty = function(obj){
		return (obj === undefined || obj === null);
    };
	
	/**
	 * Volta para a tela principal
	 */
	var voltarParaPrincipal = function(){
		$timeout(function(){
			$('#irParaHome').click();
		});
    };
    

	return message;	
	
}]);
