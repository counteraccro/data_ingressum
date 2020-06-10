<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
        return $this->render('home/index.html.twig', []);
    }

    /**
     *
     *  @Route("/home_graph", name="home_graph")
     */
    public function index_graph()
    {
        return $this->render('home/index.html.twig', []);
    }
}
