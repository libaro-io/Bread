<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Illuminate\Support\Collection;
use Libaro\Bread\Contracts\Field;

final class Tab extends Field
{
    public $type = 'tab';

    public $fields;
    protected $title;

    public function __construct()
    {
        $this->fields = new Collection();
    }

    public static function make($title, ...$fields)
    {
        $class = new self();
        $class->setTitle($title);
        $class->title = $title;
        foreach ($fields as $field) {
            $class->fields->push($field);
        }

        return $class;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = (array)$this;
        $array['component'] = $this->vueComponent ?? ucfirst($this->type);
        $array['fields'] = $this->fields->map(function (Field $field) {
            return $field->toArray();
        })->toArray();

        return $array;
    }
}
