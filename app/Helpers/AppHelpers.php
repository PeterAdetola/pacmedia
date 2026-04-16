<?php

if (!function_exists('lqipKey')) {
    function lqipKey(string $path): string {
        return preg_replace('/[^a-zA-Z0-9]/', '_', $path);
    }
}
