<?php
namespace App\Service;

use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use App\Entity\Valeur;
use App\Repository\ValeurRepository;
use App\Entity\Data;

/**
 *
 * @author Aymeric
 *        
 */
class DataService
{

    /**
     *
     * @var Doctrine
     */
    private $doctrine;

    /**
     *
     * @var ValeurRepository
     */
    private $valeurRepository;

    /**
     */
    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->valeurRepository = $this->doctrine->getRepository(Valeur::class);
    }

    public function getValueByDate(int $data_id, $date)
    {
        return $this->valeurRepository->findBy(array(
            'data_id' => $data_id,
            'date' => $date
        ));
    }

    /**
     * Retourne un tableau avec un clée la date et en valeur la valeur d'une data pour une semaine d'une année
     *
     * @param Data $data
     * @param int $weekNumber
     * @param int $year
     * @return string[]|\App\Entity\Valeur[]
     */
    public function getValueInWeek(Data $data, int $weekNumber, int $year)
    {
        $week = $this->getDaysInWeek($weekNumber, $year);

        $result = $this->valeurRepository->findbyDataAndBetweenDate($data, date('Y-m-d', $week[0]), date('Y-m-d', $week[6]));

        $return = array();
        foreach ($week as $day) {
            /** @var Valeur $valeur **/
            foreach ($result as $valeur) {

                if ($valeur->getDate()->format('Y-m-d') == date('Y-m-d', $day)) {
                    $return[$day] = $valeur;
                } else {
                    $return[$day] = '';
                }
            }
        }
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
}
