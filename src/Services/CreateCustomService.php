<?php

namespace Libaro\Bread\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Libaro\Bread\ValueObjects\Types;

class CreateCustomService
{
    public static function isNameValid(string $name): bool
    {
        return preg_match(
            '/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/',
            $name
        );
    }

    public static function transformName(string $name): string
    {
        return Str::ucfirst(Str::camel($name));
    }

    public static function copyFiles(string $name, int $type): array
    {
        [$pathPhp, $pathVue] = Types::getPaths($type);
        [$stubPhp, $stubVue] = Types::getStubs($type);

        self::copyStub($pathPhp, $stubPhp, $name);
        self::copyStub($pathVue, $stubVue, $name);

        return [$pathPhp, $pathVue];
    }

    protected static function copyStub($path, $stub, $name)
    {
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        File::put($path . "/$name.php", self::getContent($stub, $name));
    }

    protected static function getContent($stub, $name): string
    {
        $contents = File::get($stub);

        return str_replace("{{class}}", $name, $contents);
    }
}
