<?php

declare(strict_types=1);

namespace Libaro\Bread\Contracts;

interface ComponentsInterface
{
    /**
     * @return mixed
     */
    public function header();

    /**
     * @return mixed
     */
    public function aboveForm();

    /**
     * @return mixed
     */
    public function belowForm();
}
