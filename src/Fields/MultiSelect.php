<?php
declare(strict_types=1);


namespace Libaro\Bread\Fields;

use Libaro\Bread\Contracts\Field;
use Illuminate\Support\Collection;

final class MultiSelect extends Field
{
    public $type = 'multiSelect';
    public Collection $options;

    /**
     * @param string $name
     * @param string $label
     * @param Collection $options
     */
    public function __construct(string $name, string $label, Collection $options)
    {
        parent::__construct($name, $label);
        $this->options = $options;
    }

    public static function make(string $name, string $label, Collection $options)
    {
        return new self($name, $label, $options);
    }
}
