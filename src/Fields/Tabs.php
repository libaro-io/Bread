<?php
declare(strict_types=1);


namespace Libaro\Bread\Fields;

use Illuminate\Support\Collection;
use Libaro\Bread\Contracts\Field;
use Libaro\Bread\Fields\Fields;

final class Tabs
{
    public $type = 'tabs';
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
        $array = (array)$this;
        $array['component'] = $this->vueComponent ?? ucfirst($this->type);
        $array['tabs'] = $this->tabs
            ->map(function (Field $tab) {
                return $tab->toArray();
            })
            ->toArray();

        return $array;
    }
}