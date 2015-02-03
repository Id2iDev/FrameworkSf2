<?php

namespace Id2i\Tools\ServiceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ServiceBundle');

        $this->assertTrue($crawler->filter('html:contains("Hello")')->count() > 0);
    }
}
