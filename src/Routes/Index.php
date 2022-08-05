<?php

declare(strict_types=1);

namespace Libaro\Bread\Routes;

use Libaro\Bread\Contracts\Route;

final class Index extends Route
{
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
