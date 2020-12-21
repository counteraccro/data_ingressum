Navbar = {};

/**
 * Objet JS qui va gérer le menu gauche
 */
Navbar.Launch = function(params) {
	
	Navbar.Event = function() {
		
		$('#nav-menu-top .nav-modal').click(function() {

			Navbar.Ajax($(this).attr('href'), '#content-modal', false, 'GET');
			return false;
		});

		$('#nav-menu-top .nav-ajax').click(function() {

			Navbar.Ajax($(this).attr('href'), '#page-content', true, 'GET');
			return false;
		});

	},
	
	/**
	 * Méthode Ajax qui va charger l'element présent dans l'URL
	 */
	Navbar.Ajax = function(url, id_done, loader = true, method = 'GET')
	{
		if(loader)
		{
			$(id_done).loader();
		}
		
		$.ajax({
			method: method,
			url: url,
		})
		.done(function( html ) {
			$(id_done).html(html);
		});
	}
}