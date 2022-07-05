<?php

namespace Libaro\Bread\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

abstract class Filter
{
    protected string $label;
    protected string $field;
    protected string $type;
    protected array $options = [];
    protected Collection $filterMethods;
    protected string $operator = '=';

    /**
     * @param string $label
     * @param string $field
     */
    public function __construct(string $label, string $field)
    {
        $this->label = $label;
        $this->field = $field;
        $this->filterMethods = new Collection();
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return $this->{$name}(...$arguments);
        }

        $this->filterMethods->put($name, $arguments);

        return $this;
    }

    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    public function setField(string $field)
    {
        $this->field = $field;

        return $this;
    }

    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function setOption(string $key, $value)
    {
        $this->options[$key] = $value;
    }

    public function toArray()
    {
        return [
            'label' => $this->label,
            'field' => $this->field,
            'type' => $this->type,
            'options' => $this->options,
            'value' => $this->getValue(),
        ];
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     * @return Filter
     */
    public function setOperator(string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function apply(Builder $builder, $value)
    {
        return $builder->where($this->getField(), $this->getOperator(), $value);
    }

    /**
     * @return Collection
     */
    public function getFilterMethods(): Collection
    {
        return $this->filterMethods;
    }

    private function getValue()
    {
        return app('request')->input("filters.{$this->getField()}");
    }
}
