<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $password_encoder;

    /**
     * UserFixtures constructor.
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->password_encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->password_encoder->encodePassword($user, '1234'));
        $user->setRoles(["ROLE_ADMIN"]);

        $user1 = new User();
        $user1->setUsername('client');
        $user1->setPassword($this->password_encoder->encodePassword($user1, '1234'));
        $user1->setRoles(["ROLE_ARTICLE"]);

        $manager->persist($user);
        $manager->persist($user1);
        $manager->flush();
    }
}
