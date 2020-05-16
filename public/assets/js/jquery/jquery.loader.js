/**
 * Plugin Jquery Loader
 * @Autheur Aymeric
 */

(function($) {
  $.fn.showLoader = function()
  {
	  $(this).append('<div class="text-center float-right">' +
			'<div><i>Chargement...</i></div>' +
		  '<div class="spinner-border spinner-border-sm text-secondary" role="status">' +
		    '<span class="sr-only">Loading...</span>' +
		  '</div>' +
		  '</div>');
  };
})(jQuery);
