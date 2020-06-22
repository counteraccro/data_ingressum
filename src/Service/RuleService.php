<?php
namespace App\Service;

use App\Entity\Rule;
use Doctrine\Common\Collections\Collection;

/**
 * Service qui va gérer les règles de gestions de saisie des données
 * @author Aymeric
 *        
 */
class RuleService
{
    public function checkRule(Collection $rules, $value, $div_id)
    {
        $check = true;
        $msg = [];
        
        // Si pas de règles
        if($rules->isEmpty())
        {
            return ['check' => $check, 'msg' => $msg];
        }
        
        
        foreach($rules as $rule)
        {
            /** @var Rule $rule **/
            if(!preg_match($rule->getRule(), $value))
            {
                $check = false;
                $msg[] = ['data' => $rule->getData()->getId(), 'div_id' => $div_id,  'msg' => $rule->getErreurMessage()];
            }
        }
        
        return ['check' => $check, 'msg' => $msg];
        
    }
}