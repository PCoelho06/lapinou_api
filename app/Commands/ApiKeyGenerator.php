<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ApiKeyGenerator extends BaseCommand
{
    protected $group = 'Custom Commands';
    protected $name = 'app:generate-api-key';
    protected $description = 'Generate a new API key';

    public function run(array $params)
    {
        $apiKey = bin2hex(random_bytes(32));
        CLI::write('Generated API Key: ' . $apiKey);

        return EXIT_SUCCESS;
    }
}