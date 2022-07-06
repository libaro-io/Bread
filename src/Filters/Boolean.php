<?php

namespace Libaro\Bread\Filters;

class Boolean extends Filter
{
    public function __construct(string $label, string $field)
    {
        parent::__construct($label, $field);

        $this->setType('boolean');
    }

    public static function make(string $label, string $field)
    {
        return new self($label, $field);
    }
}
