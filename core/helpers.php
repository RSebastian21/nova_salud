<?php

function url(string $path = ''): string
{
    $base = BASE_URL === '' ? '' : BASE_URL;
    return $base . '/index.php' . ($path !== '' ? '?url=' . trim($path, '/') : '');
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function money(float|string $value): string
{
    return number_format((float) $value, 2);
}

function old(string $key, mixed $default = ''): mixed
{
    return $_POST[$key] ?? $default;
}

