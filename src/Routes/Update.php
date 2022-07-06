<?php

declare(strict_types=1);

namespace Libaro\Bread\Routes;

use Libaro\Bread\Contracts\Route;

final class Update extends Route
{
    protected $identifier = 'id';

    public function __construct($name, $identifier = 'id')
    {
        $this->name = $name;
        $this->identifier = $identifier;
    }

    public static function make($name, $identifier = 'id')
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
