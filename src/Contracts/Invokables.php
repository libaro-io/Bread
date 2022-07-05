<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

interface Invokables
{
    public function __invoke(Renderer $renderer);
}
