<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

abstract class IndexComponents implements ComponentsInterface
{
    public function header()
    {
    }

    public function aboveForm()
    {
        return null;
    }

    public function belowForm()
    {
        return null;
    }
}
