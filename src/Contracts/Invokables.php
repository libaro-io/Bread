<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

interface Invokables
{
    /**
     * @param Renderer $renderer
     * @return mixed
     */
    public function __invoke(Renderer $renderer);
}
