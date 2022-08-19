<?php

declare(strict_types=1);

namespace Libaro\Bread\Headers;

use Libaro\Bread\Contracts\Header;

final class Text extends Header
{
    public function __construct(string $label, string $value)
    {
        parent::__construct($label, $value);

        $this->setType('property');
    }

    public static function make(string $label, string $value): Text
    {
        return new self($label, $value);
    }
}
