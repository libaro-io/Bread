<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Libaro\Bread\Contracts\Field;

class Fields
{
    /**
     * @var Collection<int, Field>
     */
    private Collection $fields;

    public function __construct()
    {
        $this->fields = new Collection();
    }

    /**
     * @param Field ...$fields
     * @return Fields
     */
    public static function add(...$fields): Fields
    {
        $class = new self();

        foreach ($fields as $i => $field) {
            $class->push($field);
        }

        return $class;
    }

    /**
     * @param Field $field
     * @return $this
     */
    public function push(Field $field): Fields
    {
        $this->fields->push($field);

        return $this;
    }

    public function get(): Collection
    {
        return $this->fields;
    }

    public function toArray(): Fluent
    {
        $class = new Fluent();
        $class->offsetSet('data', $this->fields
            ->map(function (Field $field) {
                return $field->toArray();
            })
            ->toArray());

        $class->offsetSet('options', $this->getOptions());

        return $class;
    }

    public function getOptions(): array
    {
        return [];
    }
}
