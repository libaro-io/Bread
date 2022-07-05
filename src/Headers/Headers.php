<?php

declare(strict_types=1);

namespace Libaro\Bread\Headers;

use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Libaro\Bread\Contracts\Header;

final class Headers
{
    protected Collection $headers;

    public function __construct()
    {
        $this->headers = new Collection();
    }

    public static function add(...$headers)
    {
        $class = new self();

        foreach ($headers as $i => $header) {
            $class->push($header);
        }

        return $class;
    }

    public function push(Header $header)
    {
        $this->headers->push($header);

        return $this;
    }

    public function get(): Collection
    {
        return $this->headers;
    }

    public function toArray()
    {
        $class = new Fluent();
        $class->offsetSet('data', $this->headers
            ->map(function (Header $header) {
                return $header->toArray();
            })
            ->toArray());

        $class->offsetSet('options', $this->getOptions());

        return $class;
    }

    public function getOptions()
    {
        return [];
    }
}
