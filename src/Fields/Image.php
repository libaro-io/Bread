<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Libaro\Bread\Contracts\Field;

final class Image extends Field
{
    public $type = 'image';

    public string $collection = 'images';

    /**
     * @param string $name
     * @param string $label
     */
    public function __construct(string $name, string $label)
    {
        parent::__construct($name, $label);
    }

    public static function make(string $name, string $label): Image
    {
        return new self($name, $label);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['collection'] = $this->collection;

        return $array;
    }
}
