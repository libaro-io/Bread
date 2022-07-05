<?php
declare(strict_types=1);


namespace Libaro\Bread\Fields;

use Libaro\Bread\Contracts\Field;
use Illuminate\Support\Collection;

final class Image extends Field
{
    public $type = 'image';

    public $collection = 'images';

    /**
     * @param string $name
     * @param string $label
     */
    public function __construct(string $name, string $label)
    {
        parent::__construct($name, $label);
    }

    public static function make(string $name, string $label)
    {
        return new self($name, $label);
    }
}
