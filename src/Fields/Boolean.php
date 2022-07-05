<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Libaro\Bread\Contracts\Field;

final class Boolean extends Field
{
    public $type = 'boolean';
    public $attributes = [];

    public static function make(string $name, string $label, array $attributes = [])
    {
        return new self($name, $label, $attributes);
    }

    public function __construct(string $name, string $label, array $attributes = [])
    {
        parent::__construct($name, $label);
        $this->attributes = $attributes;
    }
}
