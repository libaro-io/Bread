<?php

declare(strict_types=1);

namespace Libaro\Bread\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class SortingService
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @param mixed $defaultColumn
     * @param string $defaultDirection
     * @return Builder
     */
    public function __invoke(Builder $builder, $defaultColumn, string $defaultDirection): Builder
    {
        if ($request = $this->request->get('sort')) {
            if(is_array($request)){
                $builder->orderBy($request['column'], $request['direction']);
            }
        } else {
            if(is_string($defaultColumn) && is_string($defaultDirection)){
                $builder->orderBy($defaultColumn, $defaultDirection);
            }
        }

        return $builder;
    }
}
