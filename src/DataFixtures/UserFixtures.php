<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
class UserFixtures extends Fixture
{

     private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

     public function load(ObjectManager $om)
     {
 
         $super = new User();
         $super->setName("admin");
         $super->setEmail("admin@myproject.com");
         $super->setPassword($this->passwordEncoder->encodePassword(
                    $super,
                    'password'
                ));
         $om->persist($super);
         $om->flush();
     }
}
