<?php
namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;
use App\Entity\Data;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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

    public function __construct(SessionInterface $session)
    {
        
        $this->session = $session;
        // this simple example doesn't define any dependency, but in your own
        // extensions, you'll need to inject services using this constructor
    }

    /**
     * Point d'entrée pour la génération HTML de la saisie de donnée
     *
     * @param Collection $datas
     * @param string $timeline
     * @return string
     */
    public function htmlRender(Collection $datas, string $timeline)
    {
        $return = '';

        switch ($timeline) {
            case self::TIMELINE_1J:
                foreach ($datas as $data) {
                    $return .= $this->data1j($data);
                }
                break;
            case self::TIMELINE_1S:
                $return = $this->data1s($datas);
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
     * @param Collection $data
     * @return string
     */
    private function data1s(Collection $datas)
    {
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $dayTimes = $this->getDaysInWeek(date('W'), date('Y'));
        
        $this->sessionData1s($datas, date('W'), date('Y'));
        
        $return = '';
        
        $id_block = $datas->current()->getBlock()->getId();
            
        $return .= '<div class="row">
            <div class="col text-left"> < (' . $this->session->get('data.' . $id_block . '.befor.week') . ' - ' . $this->session->get('data.' . $id_block . '.befor.year') . ')</div>
            <div class="col-10 text-center">Semaine du ' . strftime('%d %B %Y', $dayTimes[0]) . ' au ' . strftime('%d %B %Y', end($dayTimes)) . '</div>
            <div class="col text-right"> > (' . $this->session->get('data.' . $id_block . '.after.week') . ' - ' . $this->session->get('data.' . $id_block . '.after.year') . ')</div>
        </div>';
        
        $return .= '<div class="row">'; 
        foreach ($dayTimes as $dayTime) {  
            $return .= '<div class="col-sm">' . strftime('%a %d', $dayTime) . '</div>';
        }
        $return .= '</div>';
        
        return $return;
    }

    /**
     * Génère un tableau de jour de la semaine
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
    
    private function sessionData1s(Collection $datas, int $weekNumber, int $year)
    {
        $befor_w = $weekNumber-1;
        $befor_year = $year;
        if($weekNumber-1 <= 0)
        {
            $befor_w = 52;
            $befor_year = $befor_year-1;
        }
        
        $after_w = date('W') +1;
        $after_year = $year;
        if($weekNumber+1 > 52)
        {
            $after_w = 1;
            $after_year = $after_year-1;
        }
        
        $this->session->set('data.' . $datas->current()->getBlock()->getId() . '.befor.week', $befor_w);
        $this->session->set('data.' . $datas->current()->getBlock()->getId() . '.after.week', $after_w);
        $this->session->set('data.' . $datas->current()->getBlock()->getId() . '.befor.year', $befor_year);
        $this->session->set('data.' . $datas->current()->getBlock()->getId() . '.after.year', $after_year);
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
                        <button class="btn btn-info" type="button" id="button-addon2">Button</button>
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
}