<?php

declare(strict_types=1);

namespace Libaro\Bread\Headers;

use Libaro\Bread\Contracts\Header;

final class Money extends Header
{
    public function __construct(string $label, string $value)
    {
        parent::__construct($label, $value);

        $this->setType('money');
        $this->options = [
            'prefix' => null,
            'suffix' => null,
            'cent_separator' => null,
            'thousand_separator' => null,
        ];
    }

    public static function make(string $label, string $value): Money
    {
        return new self($label, $value);
    }

    public function prefix(string $prefix): Money
    {
        $this->setOption('prefix', $prefix);

        return $this;
    }

    public function suffix(string $suffix): Money
    {
        $this->setOption('suffix', $suffix);

        return $this;
    }

    public function centSeparator(string $separator): Money
    {
        $this->setOption('cent_separator', $separator);

        return $this;
    }

    public function thousandSeparator(string $separator): Money
    {
        $this->setOption('thousand_separator', $separator);

        return $this;
    }
}
