<?php

namespace ConsumerService\Console;

use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * Class ShowPartnersCommand
 * @package ConsumerService\Console
 */
class ShowPartnersCommand extends Command
{
    /**
     * Show Partner List Configuration
     */
    protected function configure()
    {
        ini_set('xdebug.var_display_max_depth', '10');
        ini_set('xdebug.var_display_max_children', '256');
        ini_set('xdebug.var_display_max_data', '1024');

        $this->setName("partners-show")
            ->setDescription("Show each parner surveys, with specified status (active, inactive) and records limit.")
            ->addArgument('status', InputArgument::REQUIRED, 'Status active or inactive')
            ->addArgument('limit', InputArgument::REQUIRED, 'Records limit')
        ;
    }

    /**
     * Get partners list and display table with data
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $status = $input->getArgument('status');
        $limit = $input->getArgument('limit');

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

        //fill headers and body arrays
        $this->setTableData($array, $headers, $body);

        //build table
        $table = new Table($output);
        $table->setHeaders($headers)->setRows($body);
        $table->render();
    }

    /**
     * @param $array array
     * @param $headers array
     * @param $body array
     */
    private function setTableData(&$array, &$headers, &$body)
    {
        //build table headers
        $headers = [];
        foreach ($array[0] as $key => $item) {
            $headers[] = $key;
        }

        //build table body
        $body = [];
        foreach ($array as $key => $item) {
            $internal = [];
            $temp = [];

            foreach ($item as $k => $value) {
                //make string from surveys array
                if ($k == 'surveys') {
                    foreach ($value as $segments) {
                        $temp[] = implode(', ', $segments);
                    }

                    $internal[] = implode("\n", $temp);
                } else {
                    $internal[] = $value;
                }
            }

            $body[] = $internal;
        }
    }
}