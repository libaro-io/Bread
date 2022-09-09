<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Illuminate\Support\Collection;
use Libaro\Bread\Contracts\Field;

final class Select extends Field
{
    public $type = 'select';
    public bool $multiple = true;

    /**
     * @param string $name
     * @param string $label
     * @param Collection $options
     */
    public function __construct(string $name, string $label, Collection $options)
    {
        parent::__construct($name, $label);
        $this->options = $options;
    }

    public static function make(string $name, string $label, Collection $options): Select
    {
        return new self($name, $label, $options);
    }

    public function multiple(): Select
    {
        $this->multiple = true;

        return $this;
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['multiple'] = $this->multiple;

        return $array;
    }
}
