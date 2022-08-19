<?php

namespace Libaro\Bread\Filters;

use Illuminate\Support\Collection;
use stdClass;

class Filters
{
    private Collection $filters;
    private int $sideBarStarsAt = 5;

    public function __construct()
    {
        $this->filters = new Collection();
    }

    /**
     * @param mixed ...$filters
     * @return Filters
     */
    public static function add(...$filters): Filters
    {
        $class = new self();

        foreach ($filters as $i => $filter) {
            $class->push($filter);
        }

        return $class;
    }

    public function push(Filter $filter): Filters
    {
        $this->filters->push($filter);

        return $this;
    }

    public function get(): Collection
    {
        return $this->filters;
    }

    public function toArray(): stdClass         // TODO
    {
        $class = new stdClass();
        $class->data = $this->filters
            ->map(function (Filter $filter) {
                return $filter->toArray();
            })
            ->toArray();

        $class->options = $this->getOptions();

        return $class;
    }

    public function sideBarStarsAt(int $int): Filters
    {
        $this->sideBarStarsAt = $int;

        return $this;
    }

    public function getOptions(): array
    {
        return [
            'sidebar_starts_at' => $this->sideBarStarsAt,
        ];
    }
}
