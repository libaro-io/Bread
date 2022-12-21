<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

abstract class Component
{
    /**
     * @return string
     */
    abstract public function getVue();

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'component' => $this->getVue(),
        ];
    }
}
