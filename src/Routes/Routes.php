<?php

declare(strict_types=1);

namespace Libaro\Bread\Routes;

use Illuminate\Support\Collection;
use Libaro\Bread\Contracts\Route;

final class Routes
{
    protected Collection $routes;

    public function __construct()
    {
        $this->routes = new Collection();
    }

    public static function add(Route ...$routes): self
    {
        $class = new self();

        foreach ($routes as $i => $route) {
            $class->push($route);
        }

        return $class;
    }

    public function push(Route $header): self
    {
        $this->routes->push($header);

        return $this;
    }

    public function get(): Collection
    {
        return $this->routes;
    }

    public function toArray(): array
    {
        // TODO
        /** @phpstan-ignore-next-line */
        return $this->routes->mapWithKeys(function (Route $route) {
            return [
                $route->getType() => $route->toArray(),
            ];
        })->toArray();
    }
}
