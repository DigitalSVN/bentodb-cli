<?php

namespace App\Command\Create;

use App\Service\BentoDB;
use GuzzleHttp\Client;
use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $this->getPrinter()->info('Creating a new database...');

        $bentodb = new BentoDB(new Client(), $this->app->config->BENTODB_API_URL, $this->app->config->BENTODB_API_KEY);
        $database = $bentodb->createDatabase();

        $this->getPrinter()->success($database->message);
        $this->getPrinter()->rawOutput(json_encode($database, JSON_PRETTY_PRINT));
        $this->getPrinter()->newline();
    }
}