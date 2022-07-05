<?php
declare(strict_types=1);


namespace Libaro\Bread\Contracts;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;

abstract class Renderer implements Responsable
{
    protected string $title = '';
    protected string $action = '';
    protected $resource;
    protected $classes = [];
    protected ?Collection $components;

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


    public function with(array $array)
    {
        foreach ($array as $key => $value) {
            $this->{$key} = $value;
        }

        return $this;
    }

    public function classes($classes)
    {
        if (is_string($classes)) {
            $classes = explode(' ', $classes);
        }

        foreach ($classes as $class) {
            $this->classes[] = $class;
        }

        return $this;
    }

    public function __call($name, array $arguments)
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

        throw new \Exception('Method not found.');
    }

    public function getEntity()
    {
        return $this->entity;
    }

    protected function guessResource()
    {
        if ($this->resource) {
            return $this->resource;
        }

        $first = $this->items->first();
        if (is_object($first)) {
            $class = class_basename($first);
            $this->resource = strtolower($class);
        }

        return $this->resource;
    }

    public function components(...$components)
    {
        foreach ($components as $i => $component) {
            $class = new $component();
            $methods = get_class_methods($class);
            foreach ($methods as $methodKey => $method) {
                $this->components->put($method, $class->{$method}());
            }
        }

        return $this;
    }

    public function getComponents(): array
    {
        return $this->components->map(function ($components) {
            if ($components === null) {
                return $components;
            }

            return $components->toArray();
        })->toArray();
    }
}
