<?php

namespace ListRestAPI\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;
use ListRestAPI\Entity\Partner;

/**
 * Class PartnerObjectTest
 * @package ListRestAPI\Tests
 */
class PartnerObjectTest extends TestCase
{
    protected $em;

    /**
     * Initialize entity manager
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function setUp()
    {
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), true);
        $conn = [
            'driver' => 'pdo_mysql',
            'user' => 'list-api',
            'password' => 'root',
            'dbname' => 'list-api',
            'host' => 'localhost:8003'
        ];

        //entity manager
        $this->em = EntityManager::create($conn, $config);
    }

    /**
     * Test create object
     */
    public function testPartnerObject()
    {
        $partner = new Partner();
        $this->assertTrue(isset($partner));
        $this->assertInternalType("object", $partner);
    }

    /**
     * Get existing partner data
     */
    public function testExistingPartner()
    {
        $result = $this->em->getConnection()->query('select * from partner where name=\'partner_name_5\'')->fetchAll();
        $this->assertInternalType("array", $result);
        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('icon', $result[0]);
    }
}