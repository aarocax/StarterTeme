(function($, w) {

	var Utils = (function(){

		/**
		 * Realiza una llamada ajax usando jQuery
		 * 
		 * @param  {string}   action  nombre de la función/método a ejecutar
		 * @param  {string}   metodo  http (GET/POST)
		 * @param  {object}   vars    objeto json con las variables a pasar
		 * @param  {function} done    callback function a ejecutar cuando la llamada ajax finaliza con exito
		 * @param  {function} fail    callback function a ejecutar cuando la llamada ajax falla
		 * @param  {function} always  callback function a ejecutar siempre 
		 * 
		 * @return {object} 					objeto json con la información resultante de la llamada ajax
		 */
		var AjaxCall = function(action, method, vars, done, fail, always) {
		  $.ajax({
		    method: method,
		    url: PT_Ajax.ajaxurl,
		    data: {
		      action: action,
		      vars: vars
		    }
		  })
		    .done(function(data) {
		      if (data) {
		        var response = JSON.parse(data);
		        done(response);
		      } else {
		        console.log('no data...');
		      }
		    })
		    .fail(function(){
		      fail('ajax error....');
		    })
		    .always(function(){
		      always('ajax always....');
		    });
		}

		return {
			AjaxCall: AjaxCall,
		}

	})();

	w.SiteUtils = Utils;

})(jQuery, window);