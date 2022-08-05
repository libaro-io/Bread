<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

abstract class Field
{
    public string $type = 'text';
    public string $label = '';
    public string $name = '';
    public bool $editable = true;
    public array $classes = [
        'wrapper' => [
            'mt-6',
        ],
    ];
    /**
     * @var array
     */
    protected $options;

    public string $vueComponent;

    /**
     * @param string $name
     * @param string $label
     */
    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * @param $class
     * @param bool $overwrite
     * @return Field
     */
    public function addWrapperClass(string $class, $overwrite = false): Field
    {
        return $this->addClass('wrapper', $class, $overwrite);
    }

    /**
     * @param bool $readOnly
     * @return $this
     */
    public function readOnly(bool $readOnly = true)
    {
        $this->editable = ! $readOnly;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'component' => $this->vueComponent ?? ucfirst($this->type),
            'type' => $this->type,
            'label' => $this->label,
            'name' => $this->name,
            'editable' => $this->editable,
            'classes' => $this->classes,
            'options' => $this->options,
        ];
    }

    private function addClass(string $element, string $class, bool $overwrite = false): Field
    {
        if ($overwrite) {
            $this->classes[$element] = $class;
        } else {
            $this->classes[$element] .= " {$class}";
        }

        return $this;
    }
}
