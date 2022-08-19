<?php

declare(strict_types=1);

namespace Libaro\Bread\Headers;

use Libaro\Bread\Contracts\Header;

final class Rating extends Header
{
    public function __construct(string $label, string $value, array $options)
    {
        parent::__construct($label, $value);

        $this->setOption('settings', $options);
        $this->setType('rating');
    }

    public static function make(string $label, string $value, array $options): Rating
    {
        return new self($label, $value, $options);
    }
}
