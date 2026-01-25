<?php

namespace BrowserUseLaravel\Resources;

use BrowserUseLaravel\HttpClient;

abstract class Resource
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }
}
