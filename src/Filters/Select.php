<?php

namespace Libaro\Bread\Filters;

use Illuminate\Database\Eloquent\Builder;

class Select extends Filter
{
    public function __construct(string $label, string $field, array $values)
    {
        parent::__construct($label, $field);

        $this->setType('select');
        $this->setOption('multiple', false);
        $this->setOption('values', $values);
    }

    public static function make(string $label, string $field, array $values): Select
    {
        return new self($label, $field, $values);
    }

    public function multi(bool $multi = true): void
    {
        $this->setOption('multiple', $multi);
    }

    /**
     * @param Builder $builder
     * @param mixed $value
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        if ($this->options['multiple']) {
            return $builder->whereIn($this->field, $value);
        }

        return $builder->where($this->getField(), $this->getOperator(), $value);
    }
}
