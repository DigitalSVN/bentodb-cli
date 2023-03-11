<?php

namespace App\Command\Delete;

use App\Exception\BentoDBException;
use App\Service\BentoDB;
use GuzzleHttp\Client;
use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        if (!$this->hasParam('id')) {
            $this->getPrinter()->info('Please supply a database ID');
            $this->getPrinter()->info('./bentodb delete id=xyz');
            return;
        }

        try {
            $bentodb = new BentoDB(new Client(), $this->app->config->BENTODB_API_URL, $this->app->config->BENTODB_API_KEY);
            $database = $bentodb->deleteDatabase($this->getParam('id'));

            $this->getPrinter()->success($database->message);
            $this->getPrinter()->rawOutput(json_encode($database, JSON_PRETTY_PRINT));
            $this->getPrinter()->newline();
        }
        catch (BentoDBException $e) {
            $this->getPrinter()->error(sprintf('Error %s: %s', $e->getCode(), $e->getMessage()));
        }
    }
}