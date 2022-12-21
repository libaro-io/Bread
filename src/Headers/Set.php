<?php

declare(strict_types=1);

namespace Libaro\Bread\Headers;

use Libaro\Bread\Contracts\Header;

final class Set extends Header
{
    public function __construct(string $label, string $value, string $separator)
    {
        parent::__construct($label, $value);

        $this->setOption('separator', $separator);
        $this->setType('set');
    }

    public static function make(string $label, string $value, string $separator = ', '): Set
    {
        return new self($label, $value, $separator);
    }
}
