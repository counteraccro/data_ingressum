Mode = {};

/**
 * Objet JS qui va gérer les modes
 */
Mode.Launch = function(params) {
	
	Mode.Event = function() {
		
		/**
		 * Client sur un lien du tab
		 */
		$('#modal-mode #list-tab a').click(function(e) {
			
			$('#modal-mode #list-tab a').each(function() {
				$(this).removeClass('active');
				//$('#icon-' + $(this).data('mode')).html('');
			});
			
			//$('#icon-' + $(this).data('mode')).html('<i class="fas fa-check"></i>');
			
			
			$('#btn-change-mode').html('Passer au mode "' + $(this).data('mode-str') + '"').removeClass('disabled');
			
			if($(this).data('current') == 1)
			{
				$('#btn-change-mode').addClass('disabled').html('Choisissez un mode');
			}
			
		});
		
		/**
		 * Click sur le bouton de changement de mode
		 */
		$('#modal-mode #btn-change-mode').click(function() {
			
			if($(this).hasClass('disabled'))
			{
				return false;
			}
			
			var mode = '';
			$('#modal-mode #list-tab a').each(function() {
				if($(this).hasClass('active'))
				{
					mode = $(this).data('mode');
				}
			});
			
			var url = $(this).data('url') + '/' + mode;
			var url_reload = $(this).data('reload');
			
			console.log(url_reload);
			Mode.Ajax(url, url_reload, false, 'GET');
			
			return false;
		})
	},
	
	/**
	 * Méthode Ajax qui va charger l'element présent dans l'URL
	 */
	Mode.Ajax = function(url, url_reload, loader = true, method = 'GET')
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
			window.location.href = url_reload ;
		});
	}
}