Option = {};

/**
 * Objet JS qui va gérer le menu gauche
 */
Option.Launch = function(params) {
	
	Option.EventMenu = function() {
		
		$('#nav-menu-top #link-option').click(function() {
			calback = function() {
				$('#myModal').modal('show')
			}
			
			Option.Ajax($(this).attr('href'), '#content-modal', false, 'GET');
			
			return false;
		})
	},
	
	/**
	 * Méthode Ajax qui va charger l'element présent dans l'URL
	 */
	Option.Ajax = function(url, id_done, loader = true, method = 'GET')
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