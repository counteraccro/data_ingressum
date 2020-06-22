<?php
namespace App\Service;

use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use App\Entity\Valeur;
use App\Repository\ValeurRepository;
use App\Entity\Data;
use App\Repository\DataRepository;
use Doctrine\Common\Collections\Expr\Value;

/**
 *
 * @author Aymeric
 *        
 */
class ValeurService
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
     *
     * @var DataRepository
     */
    private $dataRepository;
    
    /**
     * 
     * @var RuleService
     */
    private $ruleService;

    /**
     */
    public function __construct(Doctrine $doctrine, RuleService $ruleService)
    {
        $this->doctrine = $doctrine;
        $this->valeurRepository = $this->doctrine->getRepository(Valeur::class);
        $this->dataRepository = $this->doctrine->getRepository(Data::class);
        $this->ruleService = $ruleService;
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
                    break;
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

    /**
     * Met à jour ou créer une valeur depuis un tableau de valeur
     * le tableau de valeur doit contenir les informations suivantes
     * [0][
     * [data_id]
     * [valeur_id]
     * [valeur]
     * [time]
     * [div_id]
     * ]
     *
     * @param array $tabValeur
     * @return string[]
     */
    public function newValeur($tabValeur = array())
    {
        $data = null;
        $msgErreur = array();
        $success = true;
        foreach ($tabValeur as $v) {
            
            if($v['valeur'] == '')
            {
                continue;
            }
            
            if ($data == null || $v['data_id'] != $data->getId()) {
                $data = $this->dataRepository->findOneBy(array(
                    'id' => $v['data_id']
                ));
            }

            $valeur = new Valeur();
            if ($v['valeur_id'] != 0) {
                $valeur = $this->valeurRepository->findOneBy(array(
                    'id' => $v['valeur_id']
                ));
            }
            
            // Cas la valeur est déjà enregistré mais l'id n'est pas encore dispo
            $result = $this->valeurRepository->findByDataAndDate($data, new \DateTime(date('d-m-Y', $v['time'])));
            if(!empty($result))
            {
                if($result[0] InstanceOf Valeur)
                    $valeur = $result[0];
            }
            
            $check = $this->ruleService->checkRule($data->getRules(), $v['valeur'], $v['div_id']);

            if($check['check'])
            {
                $valeur->setData($data);
                $valeur->setValeur($v['valeur']);
                $valeur->setDate( new \DateTime(date('d-m-Y', $v['time'])));
                $valeur->setDisabled(0);

                $this->doctrine->getManager()->persist($valeur);
            }
            else {
                $success = false;
                array_push($msgErreur, $check['msg']);
            }
        }
        $this->doctrine->getManager()->flush();

        return [
            'success' => $success, 'msg' => $msgErreur
        ];
    }
}

