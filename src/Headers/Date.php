<?php

declare(strict_types=1);

namespace Libaro\Bread\Headers;

use Libaro\Bread\Contracts\Header;

final class Date extends Header
{
    public function __construct(string $label, string $value, string $format)
    {
        parent::__construct($label, $value);

        $this->setOption('format', $format);
        $this->setType('date');
    }

    public static function make(string $label, string $value, string $format = 'DD-MM-YYYY HH:mm'): Date
    {
        return new self($label, $value, $format);
    }
}
