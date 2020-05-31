<?php
namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;
use Doctrine\Common\Collections\Collection;
use App\Service\OptionService;
use App\Entity\OptionUser;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class qui va gérer le rendu des données dans la vue
 *
 * @author Aymeric
 *        
 */
class OptionRender implements RuntimeExtensionInterface
{
    /**
     * @var Packages
     */
    private $asset;
    
    /**
     * @var UrlGeneratorInterface
     */
    private $router;
    
    public function __construct(Packages $asset, UrlGeneratorInterface $router) {
        $this->asset = $asset;
        $this->router = $router;
    }

    /**
     * Point d'entrée pour la génération des options
     *
     * @param Collection $userOption
     */
    public function htmlRender(Collection $optionUsers)
    {
        $html = '';
        
        /** @var \App\Entity\OptionUser $optionUser **/
        foreach ($optionUsers as $optionUser) {
            switch ($optionUser->getOptionData()->getType()) {

                case OptionService::$type_select:
                    $html .= $this->select($optionUser);
                    break;
                case OptionService::$type_radio:
                    $html .= $this->radio($optionUser);
                    break;

                default:
                    ;
                    break;
            }
        }

        return $html;
    }

    
    private function radio(OptionUser $optionUser) {
        $html = "";
        
        $html .= '<form>
            <div class="form-group row" style="margin-bottom:0rem">
                <label for="' . $optionUser->getOptionData()->getName() . '" class="col-sm-4 col-form-label">' . $optionUser->getOptionData()->getLabel() . '</label>
                <div class="col-sm-4">
                    <div id="btn-group-'. $optionUser->getOptionData()->getName() . '" class="btn-group" role="group" aria-label="' . $optionUser->getOptionData()->getLabel() . '">';
                         
                        $tabOption = json_decode($optionUser->getOptionData()->getChoix());
                        
                        foreach($tabOption as $key => $val)
                        {
                            $active = '';
                            if($optionUser->getValue() == $val)
                            {
                                $active = 'active';
                            }
                            
                            $html .='<button type="button" data-val="' . $val . '" class="btn btn-primary ' . $active . '">' . $key . '</button>';
                        }
                         
                     $html .='</div>
                        
                </div>
                <div class="col-sm-4">
                    <div id="valid-feedback-btn-group-'. $optionUser->getOptionData()->getName() . '" class="valid-feedback">
                       Option mise à jour avec succès <i class="fas fa-check"></i>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom:1rem">
                <div class="col-sm-4"></div>
                <div class="col-sm-8"><small id="emailHelp" class="form-text text-muted">' . $optionUser->getOptionData()->getInfo() . '</small></div>
            </div>
         </form>';
                     
         $html .= "
         <script>
               jQuery(document).ready(function(){
                  $('#btn-group-". $optionUser->getOptionData()->getName() . " .btn').click(function() {

                    if($(this).hasClass('disabled'))
                    {
                        return false;
                    }

                     $('#btn-group-". $optionUser->getOptionData()->getName() . " .btn').each(function() {
                        $(this).removeClass('active');
                        $(this).addClass('disabled');
                     });
                     
                    $(this).addClass('active');
            
                        ";
                     
                     $url = $this->router->generate('ajax_update_option', ['id_optionUser' => $optionUser->getId()]);
                     $html .= $this->generateAjaxJs($url, 'btn-group-' . $optionUser->getOptionData()->getName(), $optionUser->getOptionData()->getType());
                     
                     $html .= "});
               });
         </script>";
        
        return $html;
    }
    
    /**
     *Permet de générer le HTML d'une option de type Select
     * @param OptionUser $optionUser
     * @return string
     */
    private function select(OptionUser $optionUser)
    {
        $html = '';
        
        $html .= '<form>
            <div class="form-group row">
                <label for="' . $optionUser->getOptionData()->getName() . '" class="col-sm-4 col-form-label">' . $optionUser->getOptionData()->getLabel() . '</label>
                <div class="col-sm-8">
                    <select id="select-' . $optionUser->getOptionData()->getName() . '" class="form-control">';
        
                        $tabOption = json_decode($optionUser->getOptionData()->getChoix());
                        
                        foreach($tabOption as $key => $val)
                        {
                            $selected = '';
                            if($optionUser->getValue() == $key)
                            {
                                $selected = 'selected';
                            }
                            
                            $value = $key;
                            // Cas choix CSS
                            if($optionUser->getOptionData()->getName() == OptionService::$option_select_template)
                            {
                                $value = $this->asset->getUrl('assets/css/color_' . $key . '.css');
                            }
                            
                            $html .= '<option ' . $selected . ' data-val="' . $key . '" value="' . $value . '">' . $val . '</option>';
                        }
                    $html .= '</select>
                    <small id="emailHelp" class="form-text text-muted">' . $optionUser->getOptionData()->getInfo() . '</small>
                </div>
            </div>
        </form>';
                    
        $html .= "
         <script>
               jQuery(document).ready(function(){
                  $('#select-". $optionUser->getOptionData()->getName() . "').change(function() {";
                        
                        // Cas choix CSS
                        if($optionUser->getOptionData()->getName() == OptionService::$option_select_template)
                        {
                            $html .= "$('link.switch-template').attr('href', $(this).val());";
                        }
                        
                        $url = $this->router->generate('ajax_update_option', ['id_optionUser' => $optionUser->getId()]);
                        $html .= $this->generateAjaxJs($url, 'select-' . $optionUser->getOptionData()->getName(), $optionUser->getOptionData()->getType());
                        
                  $html .= "});
               });
         </script>

        ";
        return $html;
    }
    
    /**
     * Génère la méthode AJAX pour sauvegarder les données
     * @param string $url
     * @param int $id
     * @param int $type
     * @return string
     */
    private function generateAjaxJs($url, $id, $type)
    {
        $html = "";
        
        switch ($type) {
            case OptionService::$type_select:
                $html .= "var val = $(this).find(':selected').data('val');";
                $html .= "$('#" . $id . "').prop('disabled', true);";
            break;
            case OptionService::$type_radio:
                $html .= "var val = $(this).data('val');";
            default:
                ;
            break;
        }
        
        $html .= "
		
		$.ajax({
			method: 'GET',
			url: '" . $url . "/' + val,
            dataType: 'JSON'
		})
		.done(function( json ) {
            //json = JSON.parse(json);

			console.log(json.response);
            if(json.response)
            {";
        
                switch ($type) {
                    case OptionService::$type_select:
                        $html .= "$('#" . $id . "').addClass('is-valid').delay(2500).queue(function(next){
                            $(this).removeClass('is-valid');
                            $(this).prop('disabled', false);
                            next();
                        });";
                    break;
                    case OptionService::$type_radio:
                        $html .= " $('#valid-feedback-" . $id . "').css('display', 'block');
                            $('#" . $id . "').addClass('is-valid').delay(2500).queue(function(next){
                             $('#" . $id . " .btn').each(function() {
                                $(this).removeClass('disabled');
                                $('#valid-feedback-" . $id . "').css('display', 'none');
                            });
                            next();
                        });";
                    break;
                    default:
                        ;
                    break;
                    
                }
                
            $html .= "}
		});";
        
        return $html;
    }
}
