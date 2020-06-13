<?php
namespace App\Service;

use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use App\Entity\User;

/**
 * Service qui va gérer les modes
 * @author Aymeric
 *
 */
class ModeService {
    
    /**
     * Mode saisie de données
     * @var string
     */
    public static $mode_data = 'mode_data';
    
    /**
     * Mode statistique
     * @var string
     */
    public static $mode_stat = 'mode_stat';
    
    /**
     * mode édition
     * @var string
     */
    public static $mode_edit = 'mode_edit';
    
    /**
     * Mode Admin
     * @var string
     */
    public static $mode_admin = 'mode_admin';
    
    
    /**
     *
     * @var Doctrine
     */
    private $doctrine;
    
    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    /**
     * Permet de changer le mode d'un user
     * @param User $user
     * @param string $mode
     */
    public function changeMode(User $user, string $mode)
    {
        $user->setMode($mode);
        $this->doctrine->getManager()->flush();
    }
}