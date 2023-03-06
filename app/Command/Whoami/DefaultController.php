<?php

namespace App\Command\Whoami;

use App\Exception\BentoDBException;
use App\Service\BentoDB;
use GuzzleHttp\Client;
use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $config = $this->app->config;

        try {
            $bentodb = new BentoDB(new Client(), $this->app->config->BENTODB_API_URL, $this->app->config->BENTODB_API_KEY);
            $user = $bentodb->getUser();

            $this->getPrinter()->info('You are logged in as: ' . $user->name . ' (' . $user->email . ')');
        }
        catch (BentoDBException $e) {
            $this->getPrinter()->error('Error: ' . $e->getMessage());
        }

        $this->getPrinter()->newline();
    }
}