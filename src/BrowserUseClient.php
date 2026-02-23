<?php

namespace BrowserUseLaravel;

use BrowserUseLaravel\Resources\BillingResource;
use BrowserUseLaravel\Resources\SecretsResource;
use BrowserUseLaravel\Resources\TasksResource;
use BrowserUseLaravel\Resources\SessionsResource;
use BrowserUseLaravel\Resources\FilesResource;
use BrowserUseLaravel\Resources\ProfilesResource;
use BrowserUseLaravel\Resources\BrowsersResource;
use BrowserUseLaravel\Resources\SkillsResource;

class BrowserUseClient
{
    protected HttpClient $http;

    public function __construct(
        string $apiKey,
        string $baseUrl = 'https://api.browser-use.com/api/v2',
        int $timeout = 30,
        int $retryTimes = 3,
        int $retrySleep = 1000,
    ) {
        $this->http = new HttpClient(
            apiKey: $apiKey,
            baseUrl: $baseUrl,
            timeout: $timeout,
            retryTimes: $retryTimes,
            retrySleep: $retrySleep,
        );
    }

    /**
     * Get the billing resource.
     */
    public function billing(): BillingResource
    {
        return new BillingResource($this->http);
    }

    /**
     * Get the tasks resource.
     */
    public function tasks(): TasksResource
    {
        return new TasksResource($this->http);
    }

    /**
     * Get the secrets resource.
     */
    public function secrets(): SecretsResource
    {
        return new SecretsResource($this->http);
    }

    /**
     * Get the sessions resource.
     */
    public function sessions(): SessionsResource
    {
        return new SessionsResource($this->http);
    }

    /**
     * Get the files resource.
     */
    public function files(): FilesResource
    {
        return new FilesResource($this->http);
    }

    /**
     * Get the profiles resource.
     */
    public function profiles(): ProfilesResource
    {
        return new ProfilesResource($this->http);
    }

    /**
     * Get the browsers resource.
     */
    public function browsers(): BrowsersResource
    {
        return new BrowsersResource($this->http);
    }

    /**
     * Get the skills resource.
     */
    public function skills(): SkillsResource
    {
        return new SkillsResource($this->http);
    }

    /**
     * Get the underlying HTTP client.
     */
    public function getHttpClient(): HttpClient
    {
        return $this->http;
    }
}
