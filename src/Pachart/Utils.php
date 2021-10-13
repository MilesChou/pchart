<?php

namespace Pachart;

use Traversable;

class Utils
{
    public static function iterateToArray(iterable $var): array
    {
        if ($var instanceof Traversable) {
            return iterator_to_array($var);
        }

        return $var;
    }
}