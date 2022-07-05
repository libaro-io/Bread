<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

abstract class Field
{
    public $type = 'text';
    public string $label;
    public string $name;
    public bool $editable = true;
    public array $classes = [
        'wrapper' => [
            'mt-6',
        ],
    ];

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
    public function addWrapperClass($class, $overwrite = false)
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
        $array = (array)$this;
        $array['component'] = $this->vueComponent ?? ucfirst($this->type);

        return $array;
    }

    private function addClass(string $element, $class, $overwrite = false)
    {
        if ($overwrite) {
            $this->classes[$element] = $class;
        } else {
            $this->classes[$element] .= " {$class}";
        }

        return $this;
    }
}
