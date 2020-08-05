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
		    .fail(function(e){
		    	if(fail && typeof fail === "function") {
		      	fail(e);
		    	}
		    })
		    .always(function(){
		    	if(always && typeof always === "function") {
		      	always('ajax always....');
		    	}
		    });
		}

		/**
		 * Lee los parámetros de una url
		 * 
		 * @return {object} 	objeto json con los parámetros de la url
		 */
		var getUrlParams = function() {
		  var query_string = {};
		  var query = window.location.search.substring(1);
		  var vars = query.split("&");
		  for (var i=0;i<vars.length;i++) {
		    var pair = vars[i].split("=");
		    if (typeof query_string[pair[0]] === "undefined") {
		      query_string[pair[0]] = pair[1];
		    } else if (typeof query_string[pair[0]] === "string") {
		      var arr = [ query_string[pair[0]], pair[1] ];
		      query_string[pair[0]] = arr;
		    } else {
		      query_string[pair[0]].push(pair[1]);
		    }
		  } 
		    return query_string;
		};

		var createCookie = function(name, value, days, path) {
			if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				var expires = "; expires="+date.toGMTString();
			}
			else var expires = "";
			document.cookie = name+"="+encodeURIComponent(value)+expires+"; path=/"+path;
		}

		var readCookie = function(name) {
			return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + name.replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
		}

		var eraseCookie = function(name, path) {
			createCookie(name, "", -1, path);
		}

		return {
			AjaxCall: AjaxCall,
			getUrlParams: getUrlParams,
			CreateCookie: createCookie,
			readCookie: readCookie,
			eraseCookie: eraseCookie
		}

	})();

	w.SiteUtils = Utils;

})(jQuery, window);