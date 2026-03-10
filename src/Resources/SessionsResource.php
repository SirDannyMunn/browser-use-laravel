<?php

namespace BrowserUseLaravel\Resources;

use BrowserUseLaravel\DataTransferObjects\Session;
use BrowserUseLaravel\DataTransferObjects\SessionList;
use BrowserUseLaravel\DataTransferObjects\SessionShare;

class SessionsResource extends Resource
{
    /**
     * List all browser sessions for the project.
     *
     * GET /sessions
     *
     * @param int $pageSize Number of items per page (1-100, default 10)
     * @param int $pageNumber Page number (1-based, default 1)
     */
    public function list(int $pageSize = 10, int $pageNumber = 1): SessionList
    {
        $response = $this->http->get('/sessions', [
            'pageSize' => $pageSize,
            'pageNumber' => $pageNumber,
        ]);
        return SessionList::fromArray($response);
    }

    /**
     * Create a new browser session.
     *
     * POST /sessions
     *
     * @param string|null $profileId Profile ID to use (UUID)
     * @param string|null $proxyCountryCode Proxy country code
     * @param string|null $startUrl The URL to start the session from
     * @param int|null $browserScreenWidth Browser screen width (320-6144)
     * @param int|null $browserScreenHeight Browser screen height (320-3456)
     */
    public function create(
        ?string $profileId = null,
        ?string $proxyCountryCode = null,
        ?string $startUrl = null,
        ?int $browserScreenWidth = null,
        ?int $browserScreenHeight = null,
    ): Session {
        $data = array_filter([
            'profileId' => $profileId,
            'proxyCountryCode' => $proxyCountryCode,
            'startUrl' => $startUrl,
            'browserScreenWidth' => $browserScreenWidth,
            'browserScreenHeight' => $browserScreenHeight,
        ], fn($v) => $v !== null);

        $response = $this->http->post('/sessions', $data);
        return Session::fromArray($response);
    }

    /**
     * Get details of a specific browser session, including tasks.
     *
     * GET /sessions/{session_id}
     *
     * @param string $sessionId The session ID (UUID)
     */
    public function get(string $sessionId): Session
    {
        $response = $this->http->get("/sessions/{$sessionId}");
        return Session::fromArray($response);
    }

    /**
     * Delete a session and all its tasks.
     *
     * DELETE /sessions/{session_id}
     *
     * @param string $sessionId The session ID (UUID)
     */
    public function delete(string $sessionId): bool
    {
        return $this->http->delete("/sessions/{$sessionId}");
    }

    /**
     * Stop a session (terminate the browser and all tasks).
     *
     * PATCH /sessions/{session_id}
     *
     * @param string $sessionId The session ID (UUID)
     * @param string $action The action to perform (currently only 'stop')
     */
    public function update(string $sessionId, string $action = 'stop'): Session
    {
        $response = $this->http->patch("/sessions/{$sessionId}", [
            'action' => $action,
        ]);
        return Session::fromArray($response);
    }

    /**
     * Stop a session.
     *
     * @param string $sessionId The session ID (UUID)
     */
    public function stop(string $sessionId): Session
    {
        return $this->update($sessionId, 'stop');
    }

    /**
     * Finish a session explicitly.
     *
     * POST /sessions/{session_id}/finish
     *
     * @param string $sessionId The session ID (UUID)
     */
    public function finish(string $sessionId): Session
    {
        $response = $this->http->post("/sessions/{$sessionId}/finish");
        return Session::fromArray($response);
    }

    /**
     * Get public share info for a session.
     *
     * GET /sessions/{session_id}/public-share
     *
     * @param string $sessionId The session ID (UUID)
     */
    public function getPublicShare(string $sessionId): SessionShare
    {
        $response = $this->http->get("/sessions/{$sessionId}/public-share");
        return SessionShare::fromArray($response);
    }

    /**
     * Create or return an existing public share link for a session.
     *
     * POST /sessions/{session_id}/public-share
     *
     * @param string $sessionId The session ID (UUID)
     */
    public function createPublicShare(string $sessionId): SessionShare
    {
        $response = $this->http->post("/sessions/{$sessionId}/public-share");
        return SessionShare::fromArray($response);
    }

    /**
     * Remove public share for a session.
     *
     * DELETE /sessions/{session_id}/public-share
     *
     * @param string $sessionId The session ID (UUID)
     */
    public function deletePublicShare(string $sessionId): bool
    {
        return $this->http->delete("/sessions/{$sessionId}/public-share");
    }
}
