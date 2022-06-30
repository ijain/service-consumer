<?php

namespace ListRestAPI\Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Class PartnerControllerTest
 * @package ListRestAPI\Tests
 */
class GuzzleClientTest extends TestCase
{
    protected $client;
    protected $token;
    protected $url;

    /**
     * Initialize
     */
    public function setUp()
    {
        $this->client = new GuzzleClient();
        $this->url = 'http://localhost:8005/api/v1/partners';
        $this->token = 'e5a7e537f0c14417849dd9161cd66c4d';
    }

    /**
     * Get method - Test partner list
     */
    public function testPartnerSearchList()
    {
        $status = 'active';
        $limit = '2';

        $result = $this->client->request('GET', $this->url, [
            'query' => [
                'status' => $status,
                'limit' => $limit,
            ],
            'headers' => ['Content-type' => 'application/json'],
        ]);

        $data = json_decode($result->getBody(), true);
        $this->assertInternalType("array", $data);
        $this->assertArrayHasKey("data", $data);
        $this->assertEquals(2, count($data['data']));
    }

    /**
     * Post method - Create Partner.
     * Allowed Names: partner_name_3, partner_name_4 or partner_name_5
     */
    public function testCreatePartner()
    {
        $partner = 'partner_name_3';
        $icon = 'icon_name_3';

        $headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-type' => 'application/x-www-form-urlencoded'
        ];

        $result = $this->client->post(
            $this->url . '/create',
            [
                'headers' => $headers,
                'form_params' => [
                    'partner' => $partner,
                    'icon' => $icon
                ]
            ]
        );

        $data = json_decode($result->getBody(), true);
        $this->assertInternalType("array", $data);
        $this->assertArrayHasKey("data", $data);
        $this->assertArrayHasKey("code", $data);
        $this->assertArrayHasKey("message", $data);
        $this->assertEquals(201, $data['code']); //created
    }
}