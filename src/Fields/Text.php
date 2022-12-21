<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Libaro\Bread\Contracts\Field;

final class Text extends Field
{
    public static function make(string $name, string $label): Text
    {
        return new self($name, $label);
    }
}
