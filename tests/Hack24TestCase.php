<?php declare(strict_types=1);

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Tools\SchemaTool;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

abstract class Hack24TestCase extends WebTestCase
{
    /** @var Client */
    protected $client;
    private $em;
    private $fixtures;

    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();

        $this->em     = static::$kernel->getContainer()->get('doctrine')->getManager();

        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $tool = new SchemaTool($this->em);
            $tool->dropSchema($metadata);
            $tool->createSchema($metadata);
        }
        $this->loadFixtures();
    }

    protected function loadFixtures()
    {
        $loader = new Loader();
        $loader->addFixture(new AppFixtures());
        $executor = new ORMExecutor($this->em, new ORMPurger());
        $executor->execute($loader->getFixtures());
        $this->fixtures = $executor->getReferenceRepository();
    }

    protected function assertStatusCode(int $statusCode): void
    {
        $response = $this->client->getResponse();
        $this->assertEquals($statusCode, $response->getStatusCode());
    }

    protected function getDecodedResponse()
    {
        $response = $this->client->getResponse()->getContent();

        return json_decode($response, true);
    }

    protected function doRequest(string $method, string $url, string $body): void
    {
        $this->client->request($method, $url, [], [], [], $body);
    }
}