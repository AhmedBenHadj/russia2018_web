<?php

namespace ClientBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PagesControllerTest extends WebTestCase
{
    public function testIndexpages()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/indexPages');
    }

}
