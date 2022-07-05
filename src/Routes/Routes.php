<?php
declare(strict_types=1);


namespace Libaro\Bread\Routes;

use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Libaro\Bread\Contracts\Header;
use Libaro\Bread\Contracts\Route;

final class Routes
{
    protected $routes;

    public function __construct()
    {
        $this->routes = new Collection();
    }

    public static function add(...$routes)
    {
        $class = new self();

        foreach ($routes as $i => $route) {
            $class->push($route);
        }

        return $class;
    }


    public function push(Route $header)
    {
        $this->routes->push($header);

        return $this;
    }

    public function get(): Collection
    {
        return $this->routes;
    }

    public function toArray()
    {
        return $this->routes->mapWithKeys(function (Route $route) {
            return [
                $route->getType() => $route->toArray(),
            ];
        })->toArray();
    }
}
