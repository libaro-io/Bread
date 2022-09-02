<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Illuminate\Support\Collection;
use Libaro\Bread\Contracts\Field;

final class Tab extends Field
{
    public string $type = 'tab';

    public Collection $fields;
    protected string $title;

    public function __construct()
    {
        $this->fields = new Collection();
    }

    /**
     * @param $title
     * @param Collection ...$fields
     * @return Tab
     */
    public static function make(string $title, ...$fields): Tab
    {
        $class = new self();
        $class->setTitle($title);
        $class->title = $title;
        foreach ($fields as $field) {
            $class->fields->push($field);
        }

        return $class;
    }

    public function setTitle(string $title): Tab
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['title'] = $this->title;

        // TODO
        /** @phpstan-ignore-next-line */
        $array['fields'] = $this->fields->map(function (Field $field) {
            return $field->toArray();
        })->toArray();

        return $array;
    }
}
