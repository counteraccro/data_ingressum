<?php
namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;
use App\Entity\Data;

/**
 * Class qui va gérer le rendu des données dans la vue
 * @author Aymeric
 *
 */
class DataRender implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // this simple example doesn't define any dependency, but in your own
        // extensions, you'll need to inject services using this constructor
    }
    
    public function htmlRender(Data $data)
    {
        $return = 
        '<div class="mb-3">
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
        </div>';
        
        
        return $return;
    }
}