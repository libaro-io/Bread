<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

use Libaro\Bread\Fields\Fields;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Libaro\Bread\Routes\Routes;

abstract class Renderer implements Responsable
{
    protected string $title = '';
    protected string $action = '';

    /**
     * @var mixed
     */
    protected $entity;

    /**
     * @var mixed
     */
    protected $items;
    /**
     * @var mixed
     */
    protected $resource;
    protected array $classes = [];
    protected ?Collection $components;


    /**
     * @var ?Fields
     */
    protected $fields;
    protected ?Routes $routes = null;

    protected string $deleteMessage = 'Weet je zeker dat je dit wilt verwijderen.';

    public function __construct()
    {
        $this->components = new Collection();
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function resource(string $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    public function with(array $array): self
    {
        foreach ($array as $key => $value) {
            $this->{$key} = $value;
        }

        return $this;
    }

    /**
     * @param mixed $classes
     * @return $this
     */
    public function classes($classes): self
    {
        if (is_string($classes)) {
            $classes = explode(' ', $classes);
        }

        if (is_iterable($classes)) {
            foreach ($classes as $class) {
                $this->classes[] = $class;
            }
        }

        return $this;
    }

    public function __call(string $name, array $arguments): self
    {
        if (method_exists($this, $name)) {
            return $this->{$name}(...$arguments);
        }

        try {
            $class = $arguments[0];
            if (is_string($class)) {
                $class = app()->make($arguments[0]);
                if (!$class instanceof Invokables) {
                    throw new \Exception('Class must implement Invokables.');
                }
                $this->$name = $class($this);
            } else {
                $this->$name = $class;
            }


            return $this;
        } catch (\Exception $e) {
            dd("{$name} broke: ", $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return mixed|string
     */
    protected function guessResource()
    {
        if ($this->resource) {
            return $this->resource;
        }

        // TODO
//        /** @phpstan-ignore-next-line */
        $first = $this->items->first();

        if ($first === null && $this->items instanceof LengthAwarePaginator) {
            $path = ($this->items->path()) ? explode('/', $this->items->path()) : [];
            $this->resource = $path[count($path) - 1];
        }

        if (is_object($first)) {
            $class = class_basename($first);
            $this->resource = strtolower($class);
        }

        return $this->resource;
    }

    /**
     * @param mixed ...$components
     * @return $this
     */
    public function components(...$components)
    {
        foreach ($components as $i => $component) {
            $class = new $component();
            $methods = get_class_methods($class);
            foreach ($methods as $methodKey => $method) {
                if ($this->components) {
                    $this->components->put($method, $class->{$method}());
                }
            }
        }

        return $this;
    }

    public function getComponents(): array
    {
        return $this->components ? $this->components->map(function ($components) {
            if ($components === null) {
                return $components;
            }

            /** @phpstan-ignore-next-line  */
            return $components->toArray();
        })->toArray() : [];
    }
}
