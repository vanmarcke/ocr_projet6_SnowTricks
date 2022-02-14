<?php

namespace App\DataFixtures;

use App\Entity\SnowUser;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    protected $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public const USER_DEMO_REFERENCE = 'user';

    public function load(ObjectManager $manager): void
    {
        //create first user
        $userDemo = new SnowUser();
        $password = $this->userPasswordHasher->hashPassword($userDemo, '123456');
        $userDemo->setUsername('Fred')
        ->setEmail('vmkdev@vmkdev.com')
        ->setPassword($password)
        ->setRoles([])
        ->setIsVerified('1')
        ->setAvatar('/img/avatar.jpg')
        ->setCreatedAt(new DateTime());
        $manager->persist($userDemo);
        $manager->flush();

        $this->addReference(self::USER_DEMO_REFERENCE, $userDemo);
    }
}
