<?php

namespace Libaro\Bread\Commands;

use Illuminate\Console\Command;
use Libaro\Bread\ValueObjects\Types;
use Libaro\Bread\Services\CreateCustomService;

class CreateCustomField extends Command
{
    protected string $signature = 'bread:field {name}';

    protected string $description = 'Create a custom form Field';

    public function handle(): int
    {
        $name = $this->argument('name');

        if(!CreateCustomService::isNameValid($name)) {
            $this->error("Name: '$name' is not valid");
            return 0;
        }

        $name = CreateCustomService::transformName($name);

        [$php, $vue] = CreateCustomService::copyFiles($name, Types::Field);

        if(!$php) {
            $this->error("Custom Field: '$name' could not be created");
            return 0;
        }

        $this->info("Custom Field: '$name' created in project.");
        $this->info($php);
        $this->info($vue);

        return 0;
    }
}
