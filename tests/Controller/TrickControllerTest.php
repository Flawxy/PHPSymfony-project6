<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrickControllerTest extends WebTestCase
{
    public function testCreateTrickNotConnected()
    {
        $client = static::createClient();
        $client->request('GET', '/tricks/new');

        $response = $client->getResponse();

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testEditTrickNotConnected()
    {
        $client = static::createClient();
        $client->request('GET', '/tricks/mute/edit');

        $response = $client->getResponse();

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testDeleteTrickNotConnected()
    {
        $client = static::createClient();
        $client->request('GET', '/tricks/mute/delete');

        $response = $client->getResponse();

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testNotExistingTrickPage()
    {
        $client = static::createClient();
        $client->request('GET', '/tricks/not-existing-trick');

        $response = $client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }
}
