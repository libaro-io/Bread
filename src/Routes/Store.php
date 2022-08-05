<?php

declare(strict_types=1);

namespace Libaro\Bread\Routes;

use Libaro\Bread\Contracts\Route;

final class Store extends Route
{
    protected string $identifier = 'id';

    public function __construct(string $name, string $identifier = 'id')
    {
        $this->name = $name;
        $this->identifier = $identifier;
    }

    public static function make(string $name, string $identifier = 'id'): self
    {
        return new static($name, $identifier);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'identifier' => $this->identifier,
        ]);
    }
}
