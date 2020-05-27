<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Service\DefaultDataService;

class UserFixtures extends Fixture
{

    private $passwordEncoder;
    
    /**
     * 
     * @var DefaultData;
     */
    private $defaultDataService;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, DefaultDataService $defaultDataService)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->defaultDataService = $defaultDataService;
    }

    public function load(ObjectManager $manager)
    {
        $users = array(
            array(
                'setEmail' => 'admin@admin.com',
                'setName' => 'Aymeric',
                'setPassword' => 'passpass',
                'setRoles' => array(
                    'ROLE_ADMIN',
                    'ROLE_USER'
                )
            ),
            array(
                'setEmail' => 'user@user.com',
                'setName' => 'User - Aym',
                'setPassword' => 'passpass',
                'setRoles' => array(
                    'ROLE_USER'
                )
            )
        );

        foreach ($users as $tab) {
            $user = new User();
            foreach ($tab as $key => $value) {

                if ($key == "setPassword") {
                    $user->{$key}($this->passwordEncoder->encodePassword($user, $value));
                } else {
                    $user->{$key}($value);
                }
            }
            
            $this->defaultDataService->newData($user);
            
            $manager->persist($user);
        }
        $manager->flush();
    }
}
