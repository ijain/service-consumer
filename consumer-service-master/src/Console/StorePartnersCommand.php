<?php

namespace ConsumerService\Console;

use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class StorePartnersCommand
 * @package ConsumerService\Console
 */
class StorePartnersCommand extends Command
{
    /**
     * Store Partners Configuration
     */
    protected function configure()
    {
        ini_set('xdebug.var_display_max_depth', '10');
        ini_set('xdebug.var_display_max_children', '256');
        ini_set('xdebug.var_display_max_data', '1024');

        $this->setName("partners-store")
            ->setDescription("Store partners with active surveys in database.  Allowed partner names: partner_name_3, partner_name_4, partner_name_5.");
    }

    /**
     * Execute Command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //============== Get parners ========================
        $status = 'active';
        $limit = 50;

        $client = new GuzzleClient();
        $url = 'http://localhost:8005/api/v1/partners';

        $result = $client->request('GET', $url, [
            'query' => [
                'status' => $status,
                'limit' => $limit,
            ],
            'headers' => ['Content-type' => 'application/json'],
        ]);

        $data = json_decode($result->getBody(), true);
        $array = $data['data'];
        //============== Get parners ========================

        //============== Save parners ===========================
        foreach ($array as $item) {
            //partner name
            $partner = $item['name'];

            //partner icon
            $icon = $item['icon'];

            //security token
            $token = 'e5a7e537f0c14417849dd9161cd66c4d';

            $client = new GuzzleClient();
            $url = 'http://localhost:8005/api/v1/partners';

            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Content-type' => 'application/x-www-form-urlencoded'
            ];

            $result = $client->post(
                $url . '/create',
                [
                    'headers' => $headers,
                    'form_params' => [
                        'partner' => $partner,
                        'icon' => $icon
                    ]
                ]
            );

            //create array
            $response = json_decode($result->getBody(), true);

            //output messages
            if ($response) {
                echo 'Partner Data: ' . implode(', ', $response['data']) . "\n";
                echo 'Response code: ' . $response['code'] . "\n";
                echo 'Response Message: ' . array_key_exists('message', $response)  && isset($response['message']) ? $response['message'] : '' . "\n";
                echo 'Error: ' . array_key_exists('error', $response) && isset($response['error']) ? $response['error'] : '' . "\n";
            }
        }
        //============== Save parners ===========================
    }
}