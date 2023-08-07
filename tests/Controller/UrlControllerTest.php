<?php
/**
 * Url controller test.
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UrlControllerTest.
 */
class UrlControllerTest extends WebTestCase
{
    /**
     * Test url route.
     */
    public function testUrlRoute(): void
    {
        // given
        $client = static::createClient();

        // when
        $client->request('GET', '/url');
        $resultHttpStatusCode = $client->getResponse()->getStatusCode();

        // then
        $this->assertEquals(200, $resultHttpStatusCode);
    }
}
