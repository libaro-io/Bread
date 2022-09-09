<?php

declare(strict_types=1);

namespace Libaro\Bread\Renderers;

use Inertia\Inertia;
use Illuminate\Http\JsonResponse;
use Libaro\Bread\Contracts\Renderer;
use Libaro\Bread\Filters\Filters;
use Libaro\Bread\Headers\Headers;
use Symfony\Component\HttpFoundation\Response;

final class IndexRenderer extends Renderer
{
    protected string $title = '';
    protected ?Headers $headers = null;
    protected ?Filters $filters = null;
    protected array $actions = [];

    /**
     * @var mixed
     */
    protected $items = [];

    public static function render(): IndexRenderer
    {
        return new static();
    }

    /**
     * @param mixed $items
     * @return $this
     */
    public function items($items): self
    {
        $this->items = $items;

        return $this;
    }

    public function toResponse($request): JsonResponse|Response
    {
        return Inertia::render('Bread::Index')
            ->with([
                'headers' => $this->headers ? $this->headers->toArray() : [],
                'filters' => $this->filters ? $this->filters->toArray() : [],
                'actions' => $this->actions,
                'items' => $this->items,
                'title' => $this->title,
                'routes' => $this->routes ? $this->routes->toArray() : [],
                'resource' => $this->guessResource(),
                'deleteMessage' => $this->deleteMessage,
                'components' => $this->getComponents(),
            ])
            ->toResponse($request);
    }
}
