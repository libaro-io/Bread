<?php

namespace Libaro\Bread\Commands;

use Illuminate\Console\Command;
use Libaro\Bread\Services\CreateCustomService;
use Libaro\Bread\ValueObjects\Types;

class CreateCustomFilter extends Command
{
    protected $signature = 'bread:filter {name}';

    protected $description = 'Create a custom index Filter';

    public function handle(): int
    {
        $name = $this->argument('name');

        if (! CreateCustomService::isNameValid($name)) {
            $displayName = is_string($name) ? $name : "<uncastable to string>";
            $this->error("Name: '$displayName' is not valid");

            return 0;
        }

        $name = CreateCustomService::transformName($name);

        [$php, $vue] = CreateCustomService::copyFiles($name, Types::Filter);

        if (! $php) {
            $this->error("Custom Filter: '$name' could not be created");

            return 0;
        }

        $this->info("Custom Filter: '$name' created in project.");
        $this->info($php . '/' . $name . '.php');
        $this->info($vue . '/' . $name . '.vue');

        return 0;
    }
}
