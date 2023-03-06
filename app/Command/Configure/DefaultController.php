<?php

namespace App\Command\Configure;

use App\Exception\BentoDBException;
use App\Service\BentoDB;
use App\Service\LocalConfig;
use GuzzleHttp\Client;
use Minicli\Command\CommandController;
use Minicli\Input;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $this->getPrinter()->info('Configure your bentodb-cli installation');

        $input = new Input('API Key: ');
        $input_api_key=$input->read()."\r\n";

        /**
         * Try the key
         */
        try {
            $bentodb = new BentoDB(new Client(), $this->app->config->BENTODB_API_URL, trim($input_api_key));
            $user = $bentodb->getUser();

            /**
             * Save the api key
             */
            $this->getPrinter()->success('API Key is valid, authenticated as ' . $user->email);

            LocalConfig::set('BENTODB_API_KEY', trim($input_api_key));
        }
        catch (BentoDBException $e) {
            $this->getPrinter()->error('Error: ' . $e->getMessage());
        }

        $this->getPrinter()->newline();
    }
}