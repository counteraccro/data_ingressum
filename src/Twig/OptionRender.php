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
                    $html .= 'select ';
                    break;

                default:
                    ;
                    break;
            }
        }

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
                        $html .= $this->generateAjaxJs($url, 'select-' . $optionUser->getOptionData()->getName());
                        
                  $html .= "});
               });
         </script>

        ";
        return $html;
    }
    
    private function generateAjaxJs($url, $id)
    {
        $html = "";
        
        $html .= "$('#" . $id . "').loader();
		
		$.ajax({
			method: 'GET',
			url: '" . $url . "/' + $(this).data('val') ,
		})
		.done(function( html ) {
			
            console.log(html);

            //$('#" . $id . "').html(html);
		});";
        
        return $html;
    }
}
