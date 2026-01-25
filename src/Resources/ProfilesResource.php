<?php

namespace BrowserUseLaravel\Resources;

use BrowserUseLaravel\DataTransferObjects\Profile;
use BrowserUseLaravel\DataTransferObjects\ProfileList;

class ProfilesResource extends Resource
{
    /**
     * List all browser profiles for the project.
     *
     * GET /profiles
     *
     * @param int $pageSize Number of items per page (1-100, default 10)
     * @param int $pageNumber Page number (1-based, default 1)
     */
    public function list(int $pageSize = 10, int $pageNumber = 1): ProfileList
    {
        $response = $this->http->get('/profiles', [
            'pageSize' => $pageSize,
            'pageNumber' => $pageNumber,
        ]);
        return ProfileList::fromArray($response);
    }

    /**
     * Create a new browser profile for state persistence.
     *
     * POST /profiles
     *
     * @param string|null $name The name of the profile (max 100 characters)
     */
    public function create(?string $name = null): Profile
    {
        $data = [];
        if ($name !== null) {
            $data['name'] = $name;
        }

        $response = $this->http->post('/profiles', $data);
        return Profile::fromArray($response);
    }

    /**
     * Get details of a browser profile.
     *
     * GET /profiles/{profile_id}
     *
     * @param string $profileId The profile ID (UUID)
     */
    public function get(string $profileId): Profile
    {
        $response = $this->http->get("/profiles/{$profileId}");
        return Profile::fromArray($response);
    }

    /**
     * Update a browser profile's metadata (e.g., name).
     *
     * PATCH /profiles/{profile_id}
     *
     * @param string $profileId The profile ID (UUID)
     * @param string|null $name The new name for the profile (max 100 characters)
     */
    public function update(string $profileId, ?string $name = null): Profile
    {
        $data = [];
        if ($name !== null) {
            $data['name'] = $name;
        }

        $response = $this->http->patch("/profiles/{$profileId}", $data);
        return Profile::fromArray($response);
    }

    /**
     * Permanently delete a browser profile and its stored data.
     *
     * DELETE /profiles/{profile_id}
     *
     * @param string $profileId The profile ID (UUID)
     */
    public function delete(string $profileId): bool
    {
        return $this->http->delete("/profiles/{$profileId}");
    }
}
