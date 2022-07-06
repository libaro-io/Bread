<?php

namespace Libaro\Bread\ValueObjects;

class Types
{
    public const Field = 0;
    public const Header = 1;
    public const Filter = 2;

    public static function getPaths(int $type)
    {
        if ($type === self::Field) {
            return [
                'Bread/Fields/Custom',
                'Bread/Resources/ui/Components/Form/Fields',
            ];
        }
    }

    public static function getStubs(int $type)
    {
        if ($type === self::Field) {
            return [
                __DIR__ . "/../stubs/Field/php.stub",
                __DIR__ . "/../stubs/Field/vue.stub",
            ];
        }
    }
}
