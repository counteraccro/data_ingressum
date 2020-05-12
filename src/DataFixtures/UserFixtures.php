<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Service\DefaultData;

class UserFixtures extends Fixture
{

    private $passwordEncoder;
    
    /**
     * 
     * @var DefaultData;
     */
    private $defaultData;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, DefaultData $defaultData)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->defaultData = $defaultData;
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
            
            $this->defaultData->newData($user);
            
            $manager->persist($user);
        }
        $manager->flush();
    }
}
