<?php

namespace BrowserUseLaravel\Resources;

use BrowserUseLaravel\DataTransferObjects\Secret;
use BrowserUseLaravel\DataTransferObjects\SecretList;

class SecretsResource extends Resource
{
    public function list(
        int $pageSize = 25,
        int $pageNumber = 1,
        ?string $profileId = null,
        ?string $key = null,
    ): SecretList {
        $query = array_filter([
            'pageSize' => $pageSize,
            'pageNumber' => $pageNumber,
            'profileId' => $profileId,
            'key' => $key,
        ], fn($value) => $value !== null && $value !== '');

        $response = $this->http->get('/secrets', $query);

        return SecretList::fromArray($response);
    }

    public function create(
        string $key,
        string $value,
        ?string $profileId = null,
        ?string $description = null,
    ): Secret {
        $payload = [
            'key' => $key,
            'value' => $value,
        ];

        if (is_string($profileId) && trim($profileId) !== '') {
            $payload['profileId'] = trim($profileId);
        }

        if (is_string($description) && trim($description) !== '') {
            $payload['description'] = trim($description);
        }

        $response = $this->http->post('/secrets', $payload);

        return Secret::fromArray($response);
    }

    public function get(string $secretId): Secret
    {
        $response = $this->http->get("/secrets/{$secretId}");

        return Secret::fromArray($response);
    }

    public function update(
        string $secretId,
        ?string $key = null,
        ?string $value = null,
        ?string $profileId = null,
        ?string $description = null,
    ): Secret {
        $payload = [];

        if ($key !== null) {
            $payload['key'] = $key;
        }

        if ($value !== null) {
            $payload['value'] = $value;
        }

        if ($profileId !== null) {
            $payload['profileId'] = $profileId;
        }

        if ($description !== null) {
            $payload['description'] = $description;
        }

        $response = $this->http->patch("/secrets/{$secretId}", $payload);

        return Secret::fromArray($response);
    }

    public function delete(string $secretId): bool
    {
        return $this->http->delete("/secrets/{$secretId}");
    }
}
