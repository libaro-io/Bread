<?php

declare(strict_types=1);

namespace Libaro\Bread\Headers;

use Libaro\Bread\Contracts\Header;

final class Label extends Header
{
    public function __construct(string $label, string $value, array $options)
    {
        parent::__construct($label, $value);

        $this->setOption('cases', $options);
        $this->setType('label');
    }

    public static function make(string $label, string $value, array $options)
    {
        return new self($label, $value, $options);
    }
}
