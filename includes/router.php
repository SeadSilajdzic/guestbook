<?php

declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;

const ALLOWED_METHODS = ['GET', 'POST'];
const INDEX_URI = '';
const INDEX_ROUTE = 'index';

function normalizeURI(string $uri): string
{
    $uri = strtolower(trim($uri, '/'));
    return $uri === INDEX_URI ? INDEX_ROUTE : $uri;
}

#[NoReturn] function notFound(): void
{
    http_response_code(404);
    echo "404 Not Found";
    exit;
}

function getFilePath(string $uri, string $method): string{
    return ROUTES_DIR . '/' . normalizeURI($uri) . '/' . normalizeURI($uri) . '_' . strtolower($method) . '.php';
}

function dispatch(string $uri, string $method): void
{
    $uri = normalizeURI($uri);
    $method = strtoupper($method);

    if (!in_array($method, ALLOWED_METHODS)) {
        notFound();
    }

    $filePath = getFilePath($uri, $method);

    if(file_exists($filePath)) {
        include($filePath);
        return;
    }

    notFound();
}