<?php
declare(strict_types=1);


namespace Libaro\Bread\Contracts;


abstract class Route
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function make($name)
    {
        return new static($name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return strtolower(class_basename($this));
    }

    public function toArray()
    {
        return ['name' => $this->name];
    }

}