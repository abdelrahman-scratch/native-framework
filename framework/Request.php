<?php

namespace Framework;


class Request implements RequestInterface
{
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getQueryParams(): array
    {
        $url = $_SERVER['REQUEST_URI'];
        $parts = parse_url($url);
        parse_str($parts['query'], $query);
        return $query;
    }

    public function getUriPath(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        return parse_url($uri)["path"];
    }
}