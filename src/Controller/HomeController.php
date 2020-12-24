<?php

namespace App\Controller;

use App\Service\GitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @return Response
     */
    public function index(): Response
    {
        /** @var User $user * */
        $user = $this->getUser();

        /**
         * Choix du mode
         */
        switch ($user->getMode()) {
            case ModeService::$mode_stat:
                return $this->index_stat();
            case ModeService::$mode_edit:
                return $this->index_edit();
            case ModeService::$mode_admin:
                return $this->index_admin();
            default:
                return $this->render('home/index.html.twig', []);
        }

    }

    /**
     *
     * @Route("/home", name="home_stat")
     */
    public function index_stat(): Response
    {
        return $this->render('home/index_stat.html.twig', []);
    }

    /**
     *
     * @Route("/home", name="home_edit")
     * @return Response
     */
    public function index_edit(): Response
    {
        return $this->render('home/index_edit.html.twig', []);
    }

    /**
     *
     * @Route("/home", name="home_admin")
     */
    public function index_admin(): Response
    {
        return $this->render('home/index_admin.html.twig', []);
    }

    /**
     *
     * @Route("/news", name="news_git")
     * @param GitService $gitService
     * @return Response
     */
    public function news_git(GitService $gitService): Response
    {
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');

        $tmp = $gitService->fetchGitHubCommit();

        $commits = array();
        foreach($tmp as $commit)
        {
            $date = ucfirst(strftime('%A %d %B %Y à %r',  strtotime($commit['commit']['committer']['date'])));

            $element = [
                'committer' => $commit['commit']['committer'],
                'message' => nl2br($commit['commit']['message']),
                'sha' => $commit['sha'],
                'html_url' => $commit['html_url'],
                'avatar_url' => $commit['committer']['avatar_url'],
                'user_url' => $commit['committer']['html_url'],
                'date' => $date
            ];
            array_push($commits, $element);
        }

        return $this->render('home/news_git.html.twig', ['commits' => $commits]);
    }

    /**
     * @Route("/help", name="help")
     */
    public function help(): Response
    {
        return $this->render('home/help.html.twig');
    }
}
