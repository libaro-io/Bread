<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

interface ComponentsInterface
{
    public function header();

    public function aboveForm();

    public function belowForm();
}
