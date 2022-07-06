<?php

declare(strict_types=1);

namespace Libaro\Bread\Renderers;

use Illuminate\Database\Eloquent\Model;
use Libaro\Bread\Contracts\Renderer;

/**
 * @method fields(string $class)
 * @method routes(string $class)
 * @method components(string $class)
 */
final class FormRenderer extends Renderer
{
    protected $entity;
    private $method = 'POST';

    public function __construct($entity = null)
    {
        parent::__construct();
        if ($entity === null) {
            $entity = new class () extends Model {
            };
        }

        $this->entity = $entity;
    }

    public function setMethod($method)
    {
        if (! in_array($method, ['POST', 'PUT', 'PATCH'])) {
            throw new \InvalidArgumentException('Invalid method');
        }

        $this->method = $method;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public static function render($entity = null): FormRenderer
    {
        return new static($entity);
    }

    public function toResponse($request)
    {
        return inertia('Bread::Form')
            ->with([
                'title' => $this->title,
                'entity' => $this->entity,
                'fields' => optional($this->fields)->toArray() ?? [],
                'action' => $this->action,
                'method' => $this->getMethod(),
                'routes' => optional($this->routes)->toArray() ?? [],
                'resource' => $this->guessResource(),
                'classes' => $this->getClasses(),
                'components' => $this->getComponents(),
            ])
            ->toResponse($request);
    }

    public function getClasses()
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
