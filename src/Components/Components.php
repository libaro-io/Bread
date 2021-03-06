<?php

declare(strict_types=1);

namespace Libaro\Bread\Components;

use Illuminate\Support\Collection;
use Libaro\Bread\Contracts\Component;

final class Components
{
    private Collection $components;

    public function __construct()
    {
        $this->components = new Collection();
    }

    public static function add(...$components)
    {
        $class = new self();

        foreach ($components as $i => $component) {
            $class->push($component);
        }

        return $class;
    }

    public function push(Component $component)
    {
        $this->components->push($component);

        return $this;
    }

    public function get(): Collection
    {
        return $this->components;
    }

    public function toArray()
    {
        return $this->components->map(function (Component $component) {
            return $component->toArray();
        })->toArray();
    }

    public function getOptions()
    {
        return [];
    }
}
