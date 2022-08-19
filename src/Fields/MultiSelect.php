<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Illuminate\Support\Collection;
use Libaro\Bread\Contracts\Field;

final class MultiSelect extends Field
{
    public string $type = 'multiSelect';

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

    public static function make(string $name, string $label, Collection $options): MultiSelect
    {
        return new self($name, $label, $options);
    }
}
