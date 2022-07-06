<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class Fields
{
    public function __construct()
    {
        $this->fields = new Collection();
    }

    public static function add(...$fields)
    {
        $class = new self();

        foreach ($fields as $i => $field) {
            $class->push($field);
        }

        return $class;
    }

    public function push($field)
    {
        $this->fields->push($field);

        return $this;
    }

    public function get(): Collection
    {
        return $this->fields;
    }

    public function toArray()
    {
        $class = new Fluent();
        $class->data = $this->fields
            ->map(function ($field) {
                return $field->toArray();
            })
            ->toArray();

        $class->options = $this->getOptions();

        return $class;
    }

    public function getOptions()
    {
        return [];
    }
}
