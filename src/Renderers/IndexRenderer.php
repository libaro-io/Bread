<?php

declare(strict_types=1);

namespace Libaro\Bread\Renderers;

use Libaro\Bread\Contracts\Renderer;
use Libaro\Bread\Filters\Filters;
use Libaro\Bread\Headers\Headers;
use Libaro\Bread\Routes\Routes;

final class IndexRenderer extends Renderer
{
    protected string $title = '';
    protected ?Headers $headers = null;
    protected ?Filters $filters = null;
    protected $actions = [];
    protected $items = [];

    public static function render(): IndexRenderer
    {
        return new static();
    }

    public function items($items)
    {
        $this->items = $items;

        return $this;
    }

    public function toResponse($request)
    {
        return inertia('Bread::Index')
            ->with([
                'headers' => $this->headers->toArray(),
                'filters' => optional($this->filters)->toArray() ?? [],
                'actions' => $this->actions,
                'items' => $this->items,
                'title' => $this->title,
                'routes' => optional($this->routes)->toArray() ?? [],
                'resource' => $this->guessResource(),
                'deleteMessage' => $this->deleteMessage,
                'components' => $this->getComponents(),
            ])
            ->toResponse($request);
    }
}
