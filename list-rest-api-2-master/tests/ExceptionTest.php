<?php

namespace ListRestAPI\Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class ExceptionTest
 * @package ListRestAPI\Tests
 */
class ExceptionTest extends TestCase
{
    /**
     * Test 500 error
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function test500Exception()
    {
        $status = 'active';

        $headers = [
            'Content-type' => 'application/json'
        ];

        try {
            $guzzle = new Client();
            $response = $guzzle->request('GET', 'http://localhost:8005/api/v1/partners?status=' . $status, $headers);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $this->assertEquals(500, $response->getStatusCode());
    }

    /**
     * Test response 200
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function test200Exception()
    {
        $status = 'active';
        $limit = '3';

        $headers = [
            'Content-type' => 'application/json'
        ];

        try {
            $guzzle = new Client();
            $response = $guzzle->request('GET', 'http://localhost:8005/api/v1/partners?status=' . $status . '&limit=' . $limit, $headers);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $this->assertEquals(200, $response->getStatusCode());
    }
}