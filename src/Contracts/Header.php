<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

abstract class Header
{
    protected $value;
    protected string $label;

    protected string $type = 'property';

    protected $options = [];

    protected bool $sortable = false;
    protected bool $editable = false;

    public function __construct(string $label, string $value)
    {
        $this->setLabel($label);
        $this->setValue($value);
    }

    protected function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    protected function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    protected function setOption(string $key, $value): self
    {
        $this->options[$key] = $value;

        return $this;
    }

    protected function setType(string $type): Header
    {
        $this->type = $type;

        return $this;
    }

    /*
     * Available Options
     */

    public function editable(bool $editable = false)
    {
        $this->editable = $editable;

        return $this;
    }

    public function sortable()
    {
        $this->sortable = true;

        return $this;
    }

    public function tooltip(string $tooltip)
    {
        $this->setOption('tooltip', $tooltip);

        return $this;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'label' => $this->label,
            'value' => $this->value,
            'options' => $this->options,
            'editable' => $this->editable,
            'sortable' => $this->sortable,
        ];
    }
}
