<?php

namespace Jinas\BMLConsole\Helpers;

trait Arr
{
    public function array_pluck(array $array, string $key)
    {
        return array_map(function ($v) use ($key) {
            return is_object($v) ? $v->$key : $v[$key];
        }, $array);
    }
}
