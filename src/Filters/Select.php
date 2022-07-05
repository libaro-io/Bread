<?php

namespace Libaro\Bread\Filters;

use Illuminate\Database\Eloquent\Builder;
use Libaro\Bread\Filters\Filter;

class Select extends Filter
{
    public function __construct(string $label, string $field, array $values)
    {
        parent::__construct($label, $field);

        $this->setType('select');
        $this->setOption('multiple', false);
        $this->setOption('values', $values);
    }

    public static function make(string $label, string $field, array $values)
    {
        return new self($label, $field, $values);
    }

    public function multi(bool $multi = true)
    {
        $this->setOption('multiple', $multi);
    }

    public function apply(Builder $builder, $value)
    {
        if($this->options['multiple']) {
            return $builder->whereIn($this->field, $value);
        }

        return $builder->where($this->getField(), $this->getOperator(), $value);
    }
}
