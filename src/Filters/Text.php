<?php

namespace Libaro\Bread\Filters;

use Illuminate\Database\Eloquent\Builder;

class Text extends Filter
{
    protected string $operator = 'like';

    public function __construct(string $label, string $field)
    {
        parent::__construct($label, $field);

        $this->setType('text');
    }

    public static function make(string $label, string $field)
    {
        return new self($label, $field);
    }

    public function apply(Builder $builder, $value)
    {
        return $builder->where($this->getField(), $this->getOperator(), "%$value%");
    }
}
