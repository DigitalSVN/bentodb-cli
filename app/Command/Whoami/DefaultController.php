<?php

namespace App\Command\Whoami;

use App\Service\BentoDB;
use GuzzleHttp\Client;
use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $config = $this->app->config;

        if($config->BENTODB_API_KEY) {
            $bentodb = new BentoDB(new Client(), $this->app->config->BENTODB_API_URL, $this->app->config->BENTODB_API_KEY);
            $user = $bentodb->getUser();

            $this->getPrinter()->info('You are logged in as: ' . $user->name . ' (' . $user->email . ')');
        } else {
            $this->getPrinter()->info('There is no API KEY set');
            $this->getPrinter()->info('Run ./bentodb configure to set your API KEY');
        }

        $this->getPrinter()->newline();
    }
}