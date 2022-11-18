<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->hash = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['email'=>'ikenna@email.com', 'role' => 'ROLE_ADMIN', 'password' => '12345678'],
            ['email'=>'edmund@email.com', 'role' => null, 'password' => '12345678']
        ];

        for ($i=0; $i < count($data) ; $i++) {        
            $user = new User();
            $user->setEmail($data[$i]['email']);
            $user->setPassword(
                $this->hash->hashPassword(
                        $user,
                        $data[$i]['password']
                    )
                );
                if($data[$i]['role'] != null){
                    $user->setRoles(array($data[$i]['role']));
                }
                $manager->persist($user);
                $manager->flush();
    
        }
    }
}
