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

    public static function add(Component ...$components): self
    {
        $class = new self();

        foreach ($components as $i => $component) {
            $class->push($component);
        }

        return $class;
    }

    public function push(Component $component): self
    {
        $this->components->push($component);

        return $this;
    }

    public function get(): Collection
    {
        return $this->components;
    }

    // TODO : fix phpstan errors with this ?
    // https://stackoverflow.com/questions/66282988/how-to-get-phpstan-to-infer-the-type-for-my-laravel-collection-pipeline
    public function toArray(): array
    {
        // TODO
        /** @phpstan-ignore-next-line */
        return $this->components->map(function (Component $component) {
            return $component->toArray();
        })->toArray();
    }

    public function getOptions(): array
    {
        return [];
    }
}
