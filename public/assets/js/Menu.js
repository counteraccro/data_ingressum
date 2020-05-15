Menu = {};

/**
 * Objet JS qui va gérer le menu gauche
 */
Menu.Launch = function(params) {

	Menu.url_ajax_menu = params.url_ajax_menu;

	/**
	 * Charge le menu
	 */
	Menu.Load = function() {

		Menu.Ajax(Menu.url_ajax_menu, '#sidebar-content');
	},
	
	/**
	 * 
	 */
	Menu.Event = function() {
		
		$('.collapse.list-unstyled li a').click(function() {
			
			$('.collapse.list-unstyled li a').each(function() {
				$(this).removeClass('active');
			})
			
			$(this).addClass('active');
			Menu.Ajax($(this).attr('href'), '#page-content');
			return false;
		})
	},

	/**
	 * Méthode Ajax qui va charger l'element présent dans l'URL
	 */
	Menu.Ajax = function(url, id_done, method = 'GET')
	{	
		$.ajax({
			method: method,
			url: url,
		})
		.done(function( html ) {
			$(id_done).html(html);
		});
	}
}