Toast = {};

/**
 * Permet de gérer les toasts
 */

Toast.Launch = function() {

    /**
     * Permet de charger un toast
     * @param url
     * @constructor
     */
    Toast.Load = function(url) {
        Toast.Ajax(url, '#content-toast', false, 'GET');
    }

    /**
     * Méthode Ajax qui va charger l'element présent dans l'URL
     */
    Toast.Ajax = function(url, id_done, loader = true, method = 'GET')
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