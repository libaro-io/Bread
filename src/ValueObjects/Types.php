<?php

namespace Libaro\Bread\ValueObjects;

class Types
{
    public const Field = 0;
    public const Header = 1;
    public const Filter = 2;

    /**
     * Returns the label of given type
     *
     * @param int $type
     * @return string
     */
    public static function getLabel(int $type): string
    {
        return match ($type) {
            self::Field => 'Field',
            self::Header => 'Header',
            self::Filter => 'Filter'
        };
    }

    /**
     * Returns copy destination paths for php and vue files of given type
     *
     * @param int $type
     * @return string[]
     */
    public static function getPaths(int $type): array
    {
        if ($type === self::Field) {
            return [
                'Bread/Fields/Custom',
                'Bread/Resources/ui/Components/Form/Fields',
            ];
        } elseif ($type === self::Header) {
            return [
                'Bread/Headers/Custom',
                'Bread/Resources/ui/Components/Table/Fields',
            ];
        }
    }

    /**
     * Returns paths for php and vue stubs of given type
     *
     * @param int $type
     * @return string[]
     */
    public static function getStubs(int $type): array
    {
        return [
            __DIR__ . "/../stubs/" . self::getLabel($type) . "/php.stub",
            __DIR__ . "/../stubs/" . self::getLabel($type) . "/vue.stub",
        ];
    }
}
