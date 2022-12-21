<?php

namespace Libaro\Bread\Commands;

use Illuminate\Console\Command;
use Libaro\Bread\Services\CreateCustomService;
use Libaro\Bread\ValueObjects\Types;

class CreateCustomHeader extends Command
{
    protected $signature = 'bread:header {name}';

    protected $description = 'Create a custom index Header';

    public function handle(): int
    {
        $name = $this->argument('name');
        $name = is_string($name) ? $name : '';

        if (! CreateCustomService::isNameValid($name)) {
            $this->error("Name: '$name' is not valid");

            return 0;
        }

        $name = CreateCustomService::transformName($name);

        [$php, $vue] = CreateCustomService::copyFiles($name, Types::Header);

        if (! $php) {
            $this->error("Custom Header: '$name' could not be created");

            return 0;
        }

        $this->info("Custom Header: '$name' created in project.");
        $this->info($php . '/' . $name . '.php');
        $this->info($vue . '/' . $name . '.vue');

        return 0;
    }
}
