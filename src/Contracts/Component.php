<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

abstract class Component
{
    abstract public function getVue();

    public function toArray()
    {
        return [
            'component' => $this->getVue(),
        ];
    }
}
