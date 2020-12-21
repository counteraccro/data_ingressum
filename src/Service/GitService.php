<?php


namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class GitService
 * Permet de communiquer avec l'API de GIT
 * @package App\Service
 */
class GitService
{
    private $client;

    /**
     * GitService constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchGitHubCommit(): array
    {
        $response = '';
        try {
            $response = $this->client->request(
                'GET',
                'https://api.github.com/repos/counteraccro/data_ingressum/commits'
            );
        } catch (TransportExceptionInterface $e) {
        }

        $content = $response->toArray();

        return $content;
    }
}