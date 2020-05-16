Page = {};

/**
 * Objet JS qui va gérer les events de Page
 */
Page.Launch = function(params) {

	/**
	 * Charge le menu
	 */
	Page.Load = function(url, id) {
		
		$(id).showLoader();
		Page.Ajax(url, id);
	},
	
	/**
	 * 
	 */
	Page.Event = function(group_btn_id) {
		
		$(group_btn_id + ' .btn').click(function() {
			$('#' + $(this).parent().data('id')).showLoader();
			Page.Ajax($(this).data('url'), '#' + $(this).parent().data('id'));
		});
	},

	/**
	 * Méthode Ajax qui va charger l'element présent dans l'URL
	 */
	Page.Ajax = function(url, id_done, method = 'GET')
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