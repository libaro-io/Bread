<?php

declare(strict_types=1);

namespace Libaro\Bread\Headers;

use Libaro\Bread\Contracts\Header;

final class Link extends Header
{
    public function __construct(string $label, string $value, bool $_blank)
    {
        parent::__construct($label, $value);

        $this->setOption('_target', $_blank ? '_blank' : '_self');
        $this->setType('link');
    }

    public static function make(string $label, string $value, bool $_blank = false): Link
    {
        return new self($label, $value, $_blank);
    }
}
