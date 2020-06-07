Block = {};

/**
 * Objet JS qui va gérer les events de Block
 */
Block.Launch = function(params) {

	
	/**
	 * Gestion des events
	 */
	Block.Event1s = function(group_btn_id) {
		
		$(group_btn_id + ' .btn-switch-week').click(function() {	
			id = $(this).parent().parent().parent().parent().parent().attr('id');
			
			console.log(id);
			Block.Ajax($(this).data('url'), '#' + id);
		});
	},

	/**
	 * Méthode Ajax qui va charger l'element présent dans l'URL
	 */
	Block.Ajax = function(url, id_done, method = 'GET')
	{
		$(id_done).loader();
		$.ajax({
			method: method,
			url: url,
		})
		.done(function( html ) {
			$(id_done).html(html);
		});
	}
}