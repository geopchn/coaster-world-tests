<?php

namespace App\Tests\Helper;

use ReflectionClass;

class TestHelper
{
    public static function callMethod(object $object, string $methodName, array $args = []): mixed
    {
        $class = new ReflectionClass($object);
        $method = $class->getMethod($methodName);
        return $method->invokeArgs($object, $args);
    }
}
