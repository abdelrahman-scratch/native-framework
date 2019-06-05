<?php

namespace Framework;


interface RequestInterface
{

    public function getMethod(): string;

    public function getUriPath(): string;

    public function getQueryParams(): array;
}