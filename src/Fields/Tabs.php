<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Illuminate\Support\Collection;
use Libaro\Bread\Contracts\Field;

final class Tabs extends Field
{
    public string $type = 'tabs';
    public $tabs;

    public function __construct()
    {
        $this->tabs = new Collection();
    }

    public static function add(...$tabs)
    {
        $class = new self();

        foreach ($tabs as $i => $tab) {
            $class->push($tab);
        }

        return $class;
    }

    public function push(Tab $tab)
    {
        $this->tabs->push($tab);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['tabs'] = $this->tabs
            ->map(function (Field $tab) {
                return $tab->toArray();
            })
            ->toArray();

        return $array;
    }
}
