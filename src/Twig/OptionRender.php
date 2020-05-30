<?php
namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;
use Doctrine\Common\Collections\Collection;
use App\Service\OptionService;
use App\Entity\OptionUser;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Asset\Packages;

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
    
    public function __construct(Packages $asset) {
        $this->asset = $asset;
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
     *
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
                            if($optionUser->getOptionData()->getName() == OptionService::$option_select_template)
                            {
                                $value = $this->asset->getUrl('assets/css/color_' . $key . '.css');
                            }
                            
                            $html .= '<option ' . $selected . ' value="' . $value . '">' . $val . '</option>';
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
                        
                        if($optionUser->getOptionData()->getName() == OptionService::$option_select_template)
                        {
                            $html .= "$('link.switch-template').attr('href', $(this).val());";
                        }
                    
                  $html .= "});
               });
         </script>

        ";
        return $html;
    }
}
