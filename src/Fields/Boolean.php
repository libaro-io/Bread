<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Libaro\Bread\Contracts\Field;

final class Boolean extends Field
{
    public string $type = 'boolean';
    public array $attributes = [];

    public static function make(string $name, string $label, array $attributes = []): self
    {
        return new self($name, $label, $attributes);
    }

    public function __construct(string $name, string $label, array $attributes = [])
    {
        parent::__construct($name, $label);
        $this->attributes = $attributes;
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['attributes'] = $this->attributes;

        return $array;
    }
}
