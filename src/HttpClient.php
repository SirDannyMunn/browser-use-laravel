<?php

namespace BrowserUseLaravel;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use BrowserUseLaravel\Support\BrowserUseTlsSettings;
use BrowserUseLaravel\Exceptions\BrowserUseException;
use BrowserUseLaravel\Exceptions\NotFoundException;
use BrowserUseLaravel\Exceptions\ValidationException;
use BrowserUseLaravel\Exceptions\RateLimitException;
use BrowserUseLaravel\Exceptions\AuthenticationException;
use BrowserUseLaravel\Exceptions\PaymentRequiredException;

class HttpClient
{
    protected string $apiKey;
    protected string $baseUrl;
    protected int $timeout;
    protected int $retryTimes;
    protected int $retrySleep;
    protected mixed $tlsVerify;
    protected ?string $caBundle;
    protected ?string $environment;

    public function __construct(
        string $apiKey,
        string $baseUrl = 'https://api.browser-use.com/api/v2',
        int $timeout = 30,
        int $retryTimes = 3,
        int $retrySleep = 1000,
        mixed $tlsVerify = null,
        ?string $caBundle = null,
        ?string $environment = null,
    ) {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->timeout = $timeout;
        $this->retryTimes = $retryTimes;
        $this->retrySleep = $retrySleep;
        $this->tlsVerify = $tlsVerify;
        $this->caBundle = $caBundle;
        $this->environment = $environment;
    }

    /**
     * Create a configured pending request.
     */
    protected function request(): PendingRequest
    {
        $request = Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->withHeaders([
                'X-Browser-Use-API-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ])
            ->retry($this->retryTimes, $this->retrySleep, function (\Exception $e, PendingRequest $request) {
                // Only retry on server errors or connection issues
                return $e instanceof \Illuminate\Http\Client\ConnectionException
                    || ($e instanceof \Illuminate\Http\Client\RequestException && $e->response->serverError());
            });

        $verifyOption = BrowserUseTlsSettings::resolveVerifyOption(
            baseUrl: $this->baseUrl,
            verifySetting: $this->tlsVerify,
            caBundle: $this->caBundle,
            environment: $this->environment,
        );

        if ($verifyOption === false) {
            return $request->withoutVerifying();
        }

        if (is_string($verifyOption) && $verifyOption !== '') {
            return $request->withOptions(['verify' => $verifyOption]);
        }

        return $request;
    }

    /**
     * Make a GET request.
     */
    public function get(string $endpoint, array $query = []): array
    {
        $response = $this->request()->get($endpoint, $query);
        return $this->handleResponse($response);
    }

    /**
     * Make a GET request and return raw response (for text/plain responses).
     */
    public function getRaw(string $endpoint, array $query = []): string
    {
        $response = $this->request()->get($endpoint, $query);
        $this->checkForErrors($response);
        return $response->body();
    }

    /**
     * Make a POST request.
     */
    public function post(string $endpoint, array $data = []): array
    {
        $response = $this->request()->post($endpoint, $data);
        return $this->handleResponse($response);
    }

    /**
     * Make a PATCH request.
     */
    public function patch(string $endpoint, array $data = []): array
    {
        $response = $this->request()->patch($endpoint, $data);
        return $this->handleResponse($response);
    }

    /**
     * Make a DELETE request.
     */
    public function delete(string $endpoint): bool
    {
        $response = $this->request()->delete($endpoint);
        $this->checkForErrors($response);
        return $response->status() === 204 || $response->successful();
    }

    /**
     * Handle the API response.
     */
    protected function handleResponse(Response $response): array
    {
        $this->checkForErrors($response);
        return $response->json() ?? [];
    }

    /**
     * Check for errors in the response.
     */
    protected function checkForErrors(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        $body = $response->json() ?? [];
        $message = $body['message'] ?? $body['detail'] ?? 'Unknown error occurred';

        match ($response->status()) {
            401, 403 => throw new AuthenticationException($message, $response->status()),
            402 => throw new PaymentRequiredException($message, $response->status()),
            404 => throw new NotFoundException($message, $response->status()),
            422 => throw new ValidationException($message, $response->status(), $body['errors'] ?? []),
            429 => throw new RateLimitException($message, $response->status()),
            default => throw new BrowserUseException($message, $response->status()),
        };
    }
}
