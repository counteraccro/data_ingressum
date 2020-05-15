<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityNotFoundException;

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
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController'
        ]);
    }

    /**
     * Charge une page en ajax
     *
     * @Route("/ajax/page/{id_cat}/{id_page}", name="ajax_page", requirements={"id_cat"="\d+", "id_page"="\d+"})
     * @param int $id_cat
     * @param int $id_page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loadPage(int $id_cat, int $id_page)
    {
        /** @var \App\Entity\User $user **/
        $user = $this->getUser();
        
        /** @var \App\Entity\Categorie $categorie **/
        foreach($user->getCategories() as $categorie)
        {
            if($categorie->getId() == $id_cat)
            {
                /** @var \App\Entity\Page $page **/
                foreach($categorie->getPages() as $page)
                {
                    if($page->getId() == $id_page)
                    {
                        return $this->render('home/ajax_page.html.twig', [
                            'page' => $page
                        ]);
                    }
                }
            }
        }
        
        throw new \Exception('La réponse est 42');
    }
}
