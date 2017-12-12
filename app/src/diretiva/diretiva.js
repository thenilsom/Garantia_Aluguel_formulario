var diretiva = angular.module('diretiva', []);

/*Converte para maiusculo*/
diretiva.directive('upper', function($parse) {

	function link(scope, element, attrs, ngModelCtrl) {
			$(element).on('blur', function(){
				ngModelCtrl.$modelValue = $(element).val().toUpperCase();
				$parse(attrs.ngModel).assign(scope,ngModelCtrl.$modelValue);
				ngModelCtrl.$commitViewValue();
				ngModelCtrl.$render();
			})
		}
	

	return {
		restrict : 'A',
		require : 'ngModel',
		link : link
	};
});

/*Exibi um asterisco vermelho na label do input*/
diretiva.directive('requerido', function($parse) {

	function link(scope, element, attrs, ngModelCtrl) {
		var label = $("label[for='"+element.attr('id')+"']");
		$(label).prepend('<span style="color:red">*</span>');

		/*ao ganhar o foco remove a classe errorAtribute*/
		$(element).on('focus', function(){
			$(element).removeClass('errorAttribute');
		})

		/*ao perder o foco se o valor for vazio adiciona a classe errorAtribute*/
		$(element).on('blur', function(){
			if(!$(element).val())
				$(element).addClass('errorAttribute');
		});
		
	}
	

	return {
		restrict : 'A',
		require : 'ngModel',
		link : link
	};
});

/*Diretiva mascara
Se o acesso for via mobile a diretiva não é ativada
*/
diretiva.directive('mascara', function(serviceUtil) {

	function link(scope, el, attrs, ctrl) {
		if(!serviceUtil.isMobile()){
			$(el).mask(attrs.mascara);
			$(el).attr('type', 'text');
      		el.on('keyup', function () {
				scope.$apply(function(){
				ctrl.$setViewValue(el.val());
			});
      	});

	}else{
		$(el).attr('type', attrs.mobile)
	}
			
}
	

	return {
		restrict : 'A',
		require : 'ngModel',
		link : link
	};
});

/*Mascara Monetária*/
diretiva.directive('mascaraMonetaria', function(serviceUtil) {

	function link(scope, el, attrs, ctrl) {
		if(!serviceUtil.isMobile()){
			$(el).maskMoney({
				 prefix: "",
         		 decimal: ",",
         		 thousands: "."
			});
			$(el).attr('type', 'text');
      		el.on('keyup', function () {
				scope.$apply(function(){
				ctrl.$setViewValue(el.val());
			});
      	});

	}else{
		$(el).attr('type', attrs.mobile)
	}
			
}
	

	return {
		restrict : 'A',
		require : 'ngModel',
		link : link
	};
});

/**
 * Implementação de 'directive', para Abrir o Calendário.
 * 
 * O input que estiver com "datepicker", abre o calendário ao ser clicado.
 */
diretiva.directive('datepicker', function() {
	return {
		restrict : 'A',
		require : 'ngModel',
		link : function(scope, element, attrs, ngModelCtrl) {

			$(function() {

				$(element).datepicker({
					format : 'dd/mm/yyyy',
					language: 'pt-BR',
					autoclose : true,
					startDate : '01/01/1900',
					endDate : '31/12/2999',
					todayHighlight : true,
					clearBtn : true
				});
			});

		}
	}
});

/**
 * Implementação de 'directive', para controlar o Foco.
 * 
 * O componente que estiver com "data-focus", recebe o Foco.
 */
diretiva.directive('focus', function($timeout) {
	return {

		restrinct : 'A',

		link : function(scope, element) {
			$timeout(function() {
				element[0].focus();
			});
		}
	};
});

/**
 * Seta o tabindex passado por parametro no elemento e adiciona o manipulador de
 * evento keydow para controlar a tabulação com enter entre os elementos do
 * formulario.
 */
diretiva.directive(
		'ngTabindex',
		function() {
			return {
				restrinct : 'A',
				link : function(scope, element, attrs) {
					$(element).attr('tabindex', attrs.ngTabindex);
					$(element).keydown(
							function(event) {
								var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
								if (keyCode == 13) {
								var field = document.getElementById($(this).attr('id'));
								event.preventDefault();
								var isFocado = false;
								$($("form[name = '" + field.form.name +"']").prop('elements')).each(function(){
									
									if($(this).is(':enabled')){//verifica se o elemento esta habilitado
										var indexField = parseInt($(this).attr('tabindex'));
										var condicao = indexField > field.tabIndex;
										if(condicao){
											if(!isFocado){
												$(this).focus();
												$(this).select();
												isFocado = true;
											}
											
										}
									}
									
									
								});
									
						}

				});
				}
			}
		});