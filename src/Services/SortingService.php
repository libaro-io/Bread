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

    public function __invoke(Builder $builder, $defaultColumn, $defaultDirection): Builder
    {
        if ($request = $this->request->get('sort')) {
            $builder->orderBy($request['column'], $request['direction']);
        } else {
            $builder->orderBy($defaultColumn, $defaultDirection);
        }

        return $builder;
    }
}
