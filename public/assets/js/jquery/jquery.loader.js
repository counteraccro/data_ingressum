/**
 * Plugin Jquery Loader
 * @Autheur Aymeric
 */

(function($) {
  $.fn.loader = function()
  {
	  var height = $(this).height();
	  var width = $(this).width();
	  
	  var rand = Math.floor((Math.random() * 10) + 1);
	  
	  var str_loading = ['Chargement...', 'Loading...', 'Please wait...', '42...', 'Autodestruction...', 'ça arrive...', 'Merci de patienter...', '2 secondes please...', 'Nop !', 'Ho.. wait !', 'Paf le chien']
	  
	  $(this).prepend('<div style="position:absolute; width:' + width + 'px; height:' + height + 'px; background-color:#FAFAFA; opacity:0.7; z-index:1000; filter:alpha(opacity=70);">' +
			  '<div class="text-center align-items-center" style="z-index:1001;color:black;margin-top:'+ ((height/2)-10) +'px;">' +
			'<i>' + str_loading[rand] + '</i> ' +
		  '<div class="spinner-border spinner-border-sm text-info" role="status">' +
		    '<span class="sr-only">Loading...</span>' +
		  '</div>' +
		  '</div></div>');
  };
})(jQuery);
