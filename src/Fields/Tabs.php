<?php

declare(strict_types=1);

namespace Libaro\Bread\Fields;

use Illuminate\Support\Collection;
use Libaro\Bread\Contracts\Field;

final class Tabs extends Field
{
    public string $type = 'tabs';
    /**
     * @var Collection<Tab>
     */
    public Collection $tabs;

    public function __construct()
    {
        $this->tabs = new Collection();
    }

    /**
     * @param Tab ...$tabs
     * @return Tabs
     */
    public static function add(...$tabs): Tabs
    {
        $class = new self();

        foreach ($tabs as $i => $tab) {
            $class->push($tab);
        }

        return $class;
    }

    public function push(Tab $tab): Tabs
    {
        $this->tabs->push($tab);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
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
