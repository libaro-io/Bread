<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

abstract class Route
{
    protected string $name;

    abstract public function __construct(string $name);

    /**
     * @param string $name
     * @return static
     */
    public static function make(string $name)
    {
        return new static($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return strtolower(class_basename($this));
    }

    public function toArray(): array
    {
        return ['name' => $this->name];
    }
}
