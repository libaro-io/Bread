<?php

declare(strict_types=1);

namespace Libaro\Bread\Headers;

use Libaro\Bread\Contracts\Header;

final class InertiaLink extends Header
{
    public function __construct(string $label, string $value, string|null $name, string|null $propName = null)
    {
        parent::__construct($label, $value);

        $this->setOption('name', $name);
        $this->setOption('prop_name', $propName);
        $this->setType('inertia_link');
    }

    public static function make(string $label, string $value, string|null $name, string|null $propName = null): InertiaLink
    {
        return new self($label, $value, $name, $propName);
    }
}
