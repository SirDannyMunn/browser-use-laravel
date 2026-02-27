<?php

namespace BrowserUseLaravel\Resources;

use BrowserUseLaravel\DataTransferObjects\Account;
use BrowserUseLaravel\DataTransferObjects\AccountList;

class AccountsResource extends Resource
{
    public function list(
        int $pageSize = 25,
        int $pageNumber = 1,
        ?string $profileId = null,
        ?string $provider = null,
        ?string $accountKey = null,
    ): AccountList {
        $query = array_filter([
            'pageSize' => $pageSize,
            'pageNumber' => $pageNumber,
            'profileId' => $profileId,
            'provider' => $provider,
            'accountKey' => $accountKey,
        ], fn($value) => $value !== null && $value !== '');

        $response = $this->http->get('/accounts', $query);

        return AccountList::fromArray($response);
    }

    public function create(
        string $profileId,
        string $provider,
        string $accountKey,
        ?string $username = null,
        ?string $password = null,
        ?string $totpSeed = null,
        ?string $description = null,
    ): Account {
        $payload = [
            'profileId' => $profileId,
            'provider' => $provider,
            'accountKey' => $accountKey,
        ];
        if ($username !== null) {
            $payload['username'] = $username;
        }
        if ($password !== null) {
            $payload['password'] = $password;
        }
        if ($totpSeed !== null) {
            $payload['totpSeed'] = $totpSeed;
        }
        if ($description !== null) {
            $payload['description'] = $description;
        }

        $response = $this->http->post('/accounts', $payload);
        return Account::fromArray($response);
    }

    public function get(string $accountId): Account
    {
        $response = $this->http->get("/accounts/{$accountId}");

        return Account::fromArray($response);
    }

    public function update(
        string $accountId,
        ?string $profileId = null,
        ?string $provider = null,
        ?string $accountKey = null,
        ?string $username = null,
        ?string $password = null,
        ?string $totpSeed = null,
        ?string $description = null,
    ): Account {
        $payload = [];
        if ($profileId !== null) {
            $payload['profileId'] = $profileId;
        }
        if ($provider !== null) {
            $payload['provider'] = $provider;
        }
        if ($accountKey !== null) {
            $payload['accountKey'] = $accountKey;
        }
        if ($username !== null) {
            $payload['username'] = $username;
        }
        if ($password !== null) {
            $payload['password'] = $password;
        }
        if ($totpSeed !== null) {
            $payload['totpSeed'] = $totpSeed;
        }
        if ($description !== null) {
            $payload['description'] = $description;
        }

        $response = $this->http->patch("/accounts/{$accountId}", $payload);
        return Account::fromArray($response);
    }

    public function delete(string $accountId): bool
    {
        return $this->http->delete("/accounts/{$accountId}");
    }
}

