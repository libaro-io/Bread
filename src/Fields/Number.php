<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Libaro\Bread\Contracts\Field;

final class Number extends Field
{
    public $type = 'number';

    /**
     * @param string $name
     * @param string $label
     */
    public function __construct(string $name, string $label)
    {
        parent::__construct($name, $label);
        $this->options = ['float' => true];
    }

    public static function make(string $name, string $label): Number
    {
        return new self($name, $label);
    }

    public function integer(): Number
    {
        $this->options = ['float' => false];

        return $this;
    }
}
