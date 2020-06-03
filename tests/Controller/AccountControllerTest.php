<?php

namespace Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase
{
    /**
     * Registers a new user on the application and verifies if he's registered in DB
     *
     * @throws Exception
     */
    public function testRegistration()
    {
        $client = static::createClient();
        $client->request('GET', '/register');

        $nickname = 'TestUser' . md5(random_bytes(1));
        $mail = $nickname . '@testuser.com';
        $password = 'password123';

        $client->submitForm("Confirmer l'inscription", [
            'registration[nickname]' => $nickname,
            'registration[mail]' => $mail,
            'registration[password]' => $password,
            'registration[passwordConfirmation]' => $password
        ]);

        $entityManager = static::$kernel->getContainer()->get('doctrine');

        $result = $entityManager->getRepository(User::class)->findBy([
            'nickname' => $nickname
        ]);

        $this->assertCount(1, $result);
    }
}
