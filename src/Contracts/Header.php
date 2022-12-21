<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

abstract class Header
{
    protected string $value;
    protected string $label;

    protected string $type = 'property';

    protected array $options = [];

    protected bool $sortable = false;
    protected bool $editable = false;

    public function __construct(string $label, string $value)
    {
        $this->setLabel($label);
        $this->setValue($value);
    }

    protected function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    protected function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
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

    public function editable(bool $editable = false): self
    {
        $this->editable = $editable;

        return $this;
    }

    public function sortable(): self
    {
        $this->sortable = true;

        return $this;
    }

    public function tooltip(string $tooltip): self
    {
        $this->setOption('tooltip', $tooltip);

        return $this;
    }

    public function toArray(): array
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
