<?php

namespace Connections;

class Conn {

    public static function driver(object|string $name, ...$args)
    {
        if (class_exists($name)) {
            return new $name(...$args);
        }
    }
}