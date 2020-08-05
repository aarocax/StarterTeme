(function($){

  var print = function(value) {
  	console.log('callback function----');
  	console.log(value);
  }

  SiteUtils.AjaxCall("get_posts", "POST", {}, print, print, print);


})(jQuery);