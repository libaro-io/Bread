<?php

declare(strict_types=1);

namespace Libaro\Bread\Headers;

use Libaro\Bread\Contracts\Header;

final class Trend extends Header
{
    public function __construct(string $label, string $value)
    {
        parent::__construct($label, $value);

        $this->setType('trend');
    }

    public static function make(string $label, string $value)
    {
        return new self($label, $value);
    }
}
