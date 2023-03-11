<?php

namespace App\Command\Ls;

use App\Exception\BentoDBException;
use App\Service\BentoDB;
use GuzzleHttp\Client;
use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        try {
            $bentodb = new BentoDB(new Client(), $this->app->config->BENTODB_API_URL, $this->app->config->BENTODB_API_KEY);

            $list = $bentodb->listDatabases();
            $this->getPrinter()->success(sprintf('Your have %s databases', $list->number));
            $this->getPrinter()->rawOutput(json_encode($list, JSON_PRETTY_PRINT));
            $this->getPrinter()->newline();
        }
        catch (BentoDBException $e) {
            $this->getPrinter()->error(sprintf('Error %s: %s', $e->getCode(), $e->getMessage()));
        }
    }
}