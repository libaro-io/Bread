<?php

declare(strict_types=1);

namespace Libaro\Bread\Renderers;

use Libaro\Bread\Contracts\Renderer;
use Libaro\Bread\Filters\Filters;
use Libaro\Bread\Headers\Headers;

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

    public function toResponse($request)
    {
        // TODO : fix "Call to an undefined method Inertia\Response|Inertia\ResponseFactory::with()"
        // temporarily just ignoring phpstan for this line:
        /** @phpstan-ignore-next-line */
        return inertia('Bread::Index')
            ->with([
                'headers' => $this->headers ? $this->headers->toArray() : [],
                // TODO
                /** @phpstan-ignore-next-line */
                'filters' => optional($this->filters)->toArray() ?? [],
                'actions' => $this->actions,
                'items' => $this->items,
                'title' => $this->title,
                // TODO
                /** @phpstan-ignore-next-line */
                'routes' => optional($this->routes)->toArray() ?? [],
                'resource' => $this->guessResource(),
                'deleteMessage' => $this->deleteMessage,
                'components' => $this->getComponents(),
            ])
            ->toResponse($request);
    }
}
