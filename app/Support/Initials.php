<?php

namespace App\Support;

class Initials
{
    public static function fromName(string $name): string
    {
        $parts = collect(explode(' ', trim($name)))
            ->filter()
            ->values();

        if ($parts->count() === 1) {
            return strtoupper(substr($parts[0], 0, 1));
        }

        return strtoupper(
            substr($parts->first(), 0, 1) .
            substr($parts->last(), 0, 1)
        );
    }
}
