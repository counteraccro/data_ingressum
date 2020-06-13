<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use App\Service\ModeService;

/**
 *
 * @IsGranted("ROLE_USER")
 * @author Aymeric
 *        
 */
class HomeController extends AbstractController
{

    /**
     *
     * @Route("/home", name="home")
     *
     */
    public function index()
    {
        /** @var User $user **/
        $user = $this->getUser();

        /**
         * Choix du mode
         */
        switch ($user->getMode()) {
            case ModeService::$mode_stat:
                return $this->index_stat();
                break;
            case ModeService::$mode_edit:
                return $this->index_edit();
                break;
            case ModeService::$mode_admin:
                return $this->index_admin();
                break;
            default:
                return $this->render('home/index.html.twig', []);
                break;
        }
    }

    /**
     *
     *  @Route("/home", name="home_stat")
     */
    public function index_stat()
    {
        return $this->render('home/index_stat.html.twig', []);
    }

    /**
     *
     *  @Route("/home", name="home_edit")
     */
    public function index_edit()
    {
        return $this->render('home/index_edit.html.twig', []);
    }

    /**
     *
     *  @Route("/home", name="home_admin")
     */
    public function index_admin()
    {
        return $this->render('home/index_admin.html.twig', []);
    }
}
