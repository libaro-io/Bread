<?php

declare(strict_types=1);

namespace Libaro\Bread\Renderers;

use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;
use Libaro\Bread\Contracts\Renderer;

/**
 * @method fields(string $class)
 * @method routes(string $class)
 * @method components(string $class)
 */
final class FormRenderer extends Renderer
{
    /**
     * @var Model|mixed
     */
    protected $entity;
    private string $method = 'POST';

    /**
     * @param mixed $entity
     */
    public function __construct($entity = null)
    {
        parent::__construct();
        if ($entity === null) {
            $entity = new class () extends Model {
            };
        }

        $this->entity = $entity;
    }

    public function setMethod(string $method): FormRenderer
    {
        if (! in_array($method, ['POST', 'PUT', 'PATCH'])) {
            throw new \InvalidArgumentException('Invalid method');
        }

        $this->method = $method;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param mixed $entity
     * @return FormRenderer
     */
    public static function render($entity = null): FormRenderer
    {
        return new FormRenderer($entity);
    }

    public function toResponse($request)
    {
        return Inertia::render('Bread::Form')
            ->with([
                'title' => $this->title,
                'entity' => $this->entity,
                'fields' => $this->fields ? $this->fields->toArray() : [],
                'action' => $this->action,
                'method' => $this->getMethod(),
                'routes' => $this->routes ? $this->routes->toArray() : [],
                'resource' => $this->guessResource(),
                'classes' => $this->getClasses(),
                'components' => $this->getComponents(),
            ])
            ->toResponse($request);
    }

    public function getClasses(): array
    {
        return $this->classes;
    }

    protected function guessResource()
    {
        if ($this->resource) {
            return $this->resource;
        }

        if (is_object($this->entity)) {
            $class = class_basename($this->entity);
            $this->resource = strtolower($class);
        }

        return $this->resource;
    }
}
