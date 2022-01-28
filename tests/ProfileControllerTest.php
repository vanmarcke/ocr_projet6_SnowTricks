<?php

namespace App\Tests;

use App\Repository\SnowUserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(SnowUserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('fred@vmkdev.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur SnowTricks', 'h2', 'Les Figures');
    }
}
