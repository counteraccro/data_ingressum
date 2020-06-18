<?php
namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;
use App\Entity\Data;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\User;
use App\Service\OptionService;
use App\Service\DefaultValueService;

/**
 * Class qui va gérer le rendu des données dans la vue
 *
 * @author Aymeric
 *        
 */
class DataRender implements RuntimeExtensionInterface
{

    const TIMELINE_1J = '1j';

    const TIMELINE_1S = '1s';

    const TIMELINE_1M = '1m';

    /**
     *
     * @var SessionInterface
     */
    private $session;

    /**
     *
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     *
     * @var User
     */
    private $user;

    /**
     *
     * @var OptionService
     */
    private $optionService;

    /**
     * Contructeur
     *
     * @param SessionInterface $session
     * @param UrlGeneratorInterface $router
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(SessionInterface $session, UrlGeneratorInterface $router, TokenStorageInterface $tokenStorage, OptionService $optionService)
    {
        $this->session = $session;
        $this->router = $router;
        $this->user = $tokenStorage->getToken()->getUser();
        $this->optionService = $optionService;
    }

    /**
     * Point d'entrée pour la génération HTML de la saisie de donnée
     *
     * @param Collection $datas
     * @param string $timeline
     * @param int $numweek
     * @param int $year
     * @param array $tabValeurs
     * @return string
     */
    public function htmlRender(Collection $datas, string $timeline, int $numweek, int $year, array $tabValeurs)
    {
        $return = '';

        switch ($timeline) {
            case self::TIMELINE_1J:
                foreach ($datas as $data) {
                    $return .= $this->data1j($data);
                }
                break;
            case self::TIMELINE_1S:
                $return = $this->data1s($datas, $numweek, $year, $tabValeurs);
                break;
            case self::TIMELINE_1M:

                break;

            default:
                ;
                break;
        }

        return $return;
    }

    /**
     * Génère le HTML pour la saisie d'une semaine
     *
     * @param Collection $datas
     * @param int $numweek
     * @param int $year
     * @param array $tabValeurs
     * @return string
     */
    private function data1s(Collection $datas, int $numweek, int $year, array $tabValeurs)
    {
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $dayTimes = $this->getDaysInWeek($numweek, $year);
        $auto_save = $this->optionService->getOptionByName(OptionService::$option_auto_save);

        $this->sessionData1s($datas, $numweek, $year);

        $return = '';

        if ($datas->isEmpty()) {
            return '<div class="alert alert-primary shadow-sm"><i class="fas fa-exclamation-triangle"></i> <i>Pas de données pour le moment</i></div>';
        }

        $id_block = $datas->current()
            ->getBlock()
            ->getId();

        $url_before = $this->router->generate('ajax_block', array(
            'id' => $id_block,
            'timeline' => '1s',
            'numw' => $this->session->get('data.' . $id_block . '.befor.week'),
            'year' => $this->session->get('data.' . $id_block . '.befor.year')
        ));
        $url_after = $this->router->generate('ajax_block', array(
            'id' => $id_block,
            'timeline' => '1s',
            'numw' => $this->session->get('data.' . $id_block . '.after.week'),
            'year' => $this->session->get('data.' . $id_block . '.after.year')
        ));

        $return .= '
        <div class="card border-primary shadow">
            <div class="card-header bg-primary">
        <div class="row" id="block-time-' . $id_block . '">
            <div class="col-2 text-left"><div class="btn btn-sm btn-primary btn-switch-week" data-url="' . $url_before . '"><i class="fas fa-arrow-circle-left"></i> Précédente</div></div>
            <div class="col-8 text-center">Semaine du ' . strftime('%d %B %Y', $dayTimes[0]) . ' au ' . strftime('%d %B %Y', end($dayTimes)) . '</div>
            <div class="col-2 text-right"><div class="btn btn-sm btn-primary btn-switch-week" data-url="' . $url_after . '"> Suivante <i class="fas fa-arrow-circle-right"></i></div></div>
        </div></div>';

        $return .= '<div class="card-body">
            <div class="row">
                <div class="col-sm-3">--</div>';
        foreach ($dayTimes as $dayTime) {
            $return .= '<div class="col-sm date-str">' . strftime('%a %d', $dayTime) . '</div>';
        }
        $return .= '</div>';

        $return .= '<div id="block-input-' . $id_block . '">';

        /** @var Data $data **/
        foreach ($datas as $data) {
            $return .= '<div class="row-input-data"><div class="row">
                <div class="col-sm-3"><div class="align-middle libelle-data" data-toggle="tooltip" data-placement="left" title="' . $data->getDescription() . '">' . $data->getLibelle() . '</div></div>';

            // Cas liste
            if ($data->getType() == DefaultValueService::$type_liste) {

                $return .= '<div class="col-sm-8"></div></div></div>';

                $tab = explode(';', $data->getDefaultValue());

                $i = 0;
                // Boucle sur la liste de valeur
                foreach ($tab as $valList) {
                    $return .= '<div class="row-input-data"><div class="row">
                        <div class="col-sm-3"><div class="align-middle">&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i> ' . $valList . '</div></div>';

                    // Pour chaque jour
                    foreach ($dayTimes as $dayTime) {

                        $valeur_id = 0;
                        $valeur = '';
                        // Si la valeur existe donc déjà saisie
                        if (isset($tabValeurs[$data->getId()][$dayTime]) && $tabValeurs[$data->getId()][$dayTime] != "") {
                            $val = $tabValeurs[$data->getId()][$dayTime];
                            
                            // On explode les résultats
                            $tmpTab = explode(';', $val->getValeur());
                            foreach($tmpTab as $tmp)
                            {                                
                                $t = explode(':', $tmp);
                                // Si la valeur explode correspond à la valeur courante
                                if($t[0] == $valList)
                                {
                                    $valeur = $t[1];
                                    break;
                                }
                            }                         
                            $valeur_id = $val->getId();
                        }
                        $return .= '<div class="col-sm"><input class="form-control form-control-sm input-val input-list" data-element-list="' . $valList . '" id="' . $data->getId() . $i . '" type="text" data-time="' . $dayTime . '" data-data-id="' . $data->getId() . '" data-val-id="' . $valeur_id . '" value="' . $valeur . '" /></div>';
                        $i ++;
                    }

                    $return .= '</div></div>';
                }
                // Ajout d'un espace
                $return .= '<div class="row"><div class="col-sm-12">&nbsp;</div></div>';

                // Cas simple input
            } else {
                $i = 0;
                foreach ($dayTimes as $dayTime) {

                    $valeur = '';
                    $valeur_id = 0;
                    if (isset($tabValeurs[$data->getId()][$dayTime]) && $tabValeurs[$data->getId()][$dayTime] != "") {
                        /** @var \App\Entity\Valeur $val **/
                        $val = $tabValeurs[$data->getId()][$dayTime];
                        $valeur = $val->getValeur();
                        $valeur_id = $val->getId();
                    }

                    $return .= '<div class="col-sm"><input class="form-control form-control-sm input-val" id="' . $data->getId() . $i . '" type="text" data-time="' . $dayTime . '" data-data-id="' . $data->getId() . '" data-val-id="' . $valeur_id . '" value="' . $valeur . '" /></div>';
                    $i ++;
                }

                $return .= '</div></div>';
            }
        }

        $return .= '</div></div><div class="card-footer">';

        if ($auto_save == 1) {
            $return .= '<i class="text-primary float-sm-right">Option sauvegarde automatique activé</i>';
        } else {
            $return .= '<div class="btn btn-primary float-sm-right" id="btn-save-data-' . $id_block . '">Sauvegarder</div>';
        }

        $return .= '</div></div>';

        $return .= "
         <script>
               jQuery(document).ready(function(){

            $('.libelle-data').tooltip();";
        $url_save = $this->router->generate('ajax_save_valeur');

        if ($auto_save == 1) {
            $return .= " $('#block-input-" . $id_block . " .input-val').change(function() {
                        
                         var valeur = $(this).val();

                        if($(this).hasClass('input-list'))
                        {
                            valeur = '';
                            $('#block-input-" . $id_block . " .input-list[data-time=' + $(this).data('time') + '][data-data-id=' + $(this).data('data-id') + ']').each(function() {
                               valeur += $(this).data('element-list') + ':' + $(this).val() + ';';
                            });
                            valeur = valeur.slice(0, -1);
                        }

                        var data = {};
                        var btn = '';
                        var inputs = []
                        inputs.push($(this));
                        var data_id = $(this).data('data-id');
                        var valeur_id = $(this).data('val-id');
                       
                        var time = $(this).data('time');
                
                        $(this).prop('disabled', true);
                        data[0] = {'data_id' : data_id, 'valeur_id' : valeur_id, 'valeur' : valeur, 'time' : time};";

            $return .= $this->generateAjaxJs($url_save, '#block-input-' . $id_block, 'POST');

            $return .= "});";
        } else {

            $return .= "$('#btn-save-data-" . $id_block . "').click(function() {
                            
                            if($(this).hasClass('disabled'))
                            {
                                return false;
                            }

                            var data = {};
                            var inputs = [];
                            var btn = $(this);
                            btn.html('Chargement...');
                            
                            btn.addClass('disabled');

                            $('#block-input-" . $id_block . " .input-val').each(function() {

                                var valeur = $(this).val();
                                var id = $(this).attr('id');

                                if($(this).hasClass('input-list'))
                                {
                                    valeur = '';
                                    $('#block-input-" . $id_block . " .input-list[data-time=' + $(this).data('time') + '][data-data-id=' + $(this).data('data-id') + ']').each(function() {
                                       
                                        valeur += $(this).data('element-list') + ':' + $(this).val() + ';';
                                    });
                                    valeur = valeur.slice(0, -1);
                                    id = $(this).data('time') + $(this).data('data-id');
                                }                                

                                var data_id = $(this).data('data-id');
                                var valeur_id = $(this).data('val-id');
                               
                                var time = $(this).data('time');

                                $(this).prop('disabled', true);

                                data[id] = {'data_id' : data_id, 'valeur_id' : valeur_id, 'valeur' : valeur, 'time' : time};
                                inputs.push($(this));
                                
                            });";

            $return .= $this->generateAjaxJs($url_save, '#block-input-' . $id_block, 'POST');

            $return .= "});";
        }

        $return .= "});</script>";

        return $return;
    }

    /**
     * Génère un tableau de jour de la semaine en fonction du numéro et de l'année
     *
     * @param int $weekNumber
     * @param int $year
     * @return number[]
     */
    private function getDaysInWeek(int $weekNumber, int $year)
    {
        // Count from '0104' because January 4th is always in week 1
        // (according to ISO 8601).
        $time = strtotime($year . '0104 +' . ($weekNumber - 1) . ' weeks');
        $mondayTime = strtotime('-' . (date('w', $time) - 1) . ' days', $time);

        // Génération des jours
        $dayTimes = array();
        for ($i = 0; $i < 7; ++ $i) {
            $dayTimes[] = strtotime('+' . $i . ' days', $mondayTime);
        }

        return $dayTimes;
    }

    /**
     * Génère la semaine +1 et -1 pour les boutons de navigaton et stock la valeur en session
     *
     * @param Collection $datas
     * @param int $weekNumber
     * @param int $year
     */
    private function sessionData1s(Collection $datas, int $weekNumber, int $year)
    {
        if ($datas->isEmpty()) {
            return null;
        }

        $befor_w = $weekNumber - 1;
        $befor_year = $year;
        if ($weekNumber - 1 <= 0) {
            $befor_w = 52;
            $befor_year = $befor_year - 1;
        }

        $after_w = $weekNumber + 1;
        $after_year = $year;
        if ($weekNumber + 1 > 52) {
            $after_w = 1;
            $after_year = $after_year + 1;
        }

        $this->session->set('data.' . $datas->current()
            ->getBlock()
            ->getId() . '.befor.week', $befor_w);
        $this->session->set('data.' . $datas->current()
            ->getBlock()
            ->getId() . '.after.week', $after_w);
        $this->session->set('data.' . $datas->current()
            ->getBlock()
            ->getId() . '.befor.year', $befor_year);
        $this->session->set('data.' . $datas->current()
            ->getBlock()
            ->getId() . '.after.year', $after_year);
    }

    /**
     * Génère le HTML pour la saisie de donnée sur 1 jour
     *
     * @param Data $data
     * @return string
     */
    private function data1j(Data $data)
    {
        $return = '<div class="row">
        <div class="col-sm">
            <div class="mb-3">
                <p class="text-justify">' . $data->getDescription() . '</p>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">' . $data->getLibelle() . '</span>
                    </div>
                    <input type="text" class="form-control is-valid" placeholder="toto" value="' . $data->getDefaultValue() . '" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="button-addon2">Button</button>
                    </div>
                </div>
                <small id="emailHelp" class="form-text text-muted">' . $data->getTips() . '</small>
            </div>
        </div>
        <div class="col-sm"></div>
        </div>
        <hr />';

        return $return;
    }

    private function generateAjaxJs($url, $id, $method = 'GET', $data = null)
    {
        $return = '';

        $return .= "$.ajax({
            method: '" . $method . "',
            url: '" . $url . "',";

        if ($method == 'POST') {
            $return .= "data:{data : data}";
        }

        $return .= "})
        .done(function( response ) {
            if(response.success == true)
            {
                 for (var i = 0; i < inputs.length; i++) {
                    var input = inputs[i];
                    input.addClass('is-valid').delay(2500).queue(function(next){
                        $(this).removeClass('is-valid');
                        $(this).prop('disabled', false);
                        if(btn != '')
                        {
                            btn.removeClass('disabled');
                            btn.html('Sauvegarder');
                        }
                        next();
                    });
                }

                
            }
        });";

        return $return;
    }
}