Categorie = {};

/**
 * Objet JS qui va gérer les events pour les catégories
 */
Categorie.Launch = function(params) {

	Categorie.EventAdd = function() {

		$('#categorie-change-icon').click(function () {
			Categorie.Ajax($(this).data('url'), '#categorie-liste-fa');
		});

	};
	
	/**
	 * Méthode Ajax qui va charger l'element présent dans l'URL
	 */
	Categorie.Ajax = function(url, id_done, loader = true, method = 'GET')
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