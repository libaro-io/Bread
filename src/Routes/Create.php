<?php

declare(strict_types=1);

namespace Libaro\Bread\Routes;

use Libaro\Bread\Contracts\Route;

final class Create extends Route
{
    public function __construct($name)
    {
        $this->name = $name;
    }
}
