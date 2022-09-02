<?php

namespace Libaro\Bread\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Libaro\Bread\ValueObjects\Types;

class CreateCustomService
{
    /**
     * @param string $name
     * @return bool
     */
    public static function isNameValid($name): bool
    {
        $isValid = preg_match(
            '/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/',
            $name
        );

        return (bool) $isValid;
    }

    /**
     * @param string $name
     * @return string
     */
    public static function transformName($name): string
    {
        return Str::ucfirst(Str::camel($name));
    }

    public static function copyFiles(string $name, int $type): array
    {
        [$pathPhp, $pathVue] = Types::getPaths($type) ?? [] ;
        [$stubPhp, $stubVue] = Types::getStubs($type);

        self::copyStub($pathPhp, $stubPhp, $name, 'php');
        self::copyStub($pathVue, $stubVue, $name, 'vue');

        return [$pathPhp, $pathVue];
    }

    protected static function copyStub(string $path, string $stub, string $name, string $extension): void
    {
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        File::put("$path/$name.$extension", self::getContent($stub, $name));
    }

    protected static function getContent(string $stub, string $name): string
    {
        $contents = File::get($stub);

        $contents = str_replace("{{class}}", $name, $contents);
        $contents = str_replace("{{class_snake}}", Str::snake($name), $contents);

        return $contents;
    }
}
