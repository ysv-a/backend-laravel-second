<?php

namespace App\Services;

// Чистая функция - это функция, результат которой зависит только от введенных данных. Она не меняет никакие внешние значения и просто вычисляет результат.

class StringHelper
{
    public static function cut(string $source, int $limit): string
    {
        $len = strlen($source);

        if($len <= $limit) {
            return $source;
        }

        return substr($source, 0, $limit-3) . '...';
    }
}
