<?php

declare(strict_types=1);

namespace Libaro\Bread\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Libaro\Bread\Filters\Filters;

final class FilterService
{
    private Builder $builder;
    private Collection $filters;
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __invoke(Builder $builder, Filters $filters): Builder
    {
        $this->builder = $builder;
        $this->filters = $filters->get();
        $requestFilters = $this->request->query('filters', []);
        foreach ($requestFilters as $field => $value) {
            $this->applyFilter($field, $value);
        }

        return $this->builder;
    }

    /**
     * @param mixed $field
     * @param mixed $value
     * @return void
     */
    private function applyFilter($field, $value): void
    {
        $filter = $this->filters->firstWhere(function ($filter) use ($field) {
            return $filter->getField() === $field;
        });

        $filterMethods = $filter->getFilterMethods();
        if ($filterMethods->count() > 0) {
            foreach ($filterMethods as $method => $params) {
                $model = $this->builder->getModel();
                $methodName = 'filter'. ucfirst($method);
                if (! method_exists($model, $methodName)) {
                    $methodName = 'scope'. ucfirst($method);
                }
                $this->builder = $model->{$methodName}($this->builder, $value, $params);
            }
        } else {
            $this->builder = $filter->apply($this->builder, $value);
        }
    }
}
