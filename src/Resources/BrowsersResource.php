<?php

namespace BrowserUseLaravel\Resources;

use BrowserUseLaravel\DataTransferObjects\BrowserSession;
use BrowserUseLaravel\DataTransferObjects\BrowserSessionList;

class BrowsersResource extends Resource
{
    /**
     * List browser sessions with optional filtering by status.
     *
     * GET /browsers
     *
     * @param string|null $status Filter by status: 'active' or 'stopped'
     */
    public function list(?string $status = null): BrowserSessionList
    {
        $query = [];
        if ($status !== null) {
            $query['status'] = $status;
        }

        $response = $this->http->get('/browsers', $query);
        return BrowserSessionList::fromArray($response);
    }

    /**
     * Launch a new browser session (Chrome instance).
     *
     * POST /browsers
     *
     * @param string|null $profileId Profile ID to use (UUID)
     * @param bool $headless Whether to run in headless mode (default true)
     * @param int $timeoutSeconds Auto-stop time for the browser in seconds (default 300)
     */
    public function create(
        ?string $profileId = null,
        bool $headless = true,
        int $timeoutSeconds = 300,
    ): BrowserSession {
        $data = array_filter([
            'profileId' => $profileId,
            'headless' => $headless,
            'timeoutSeconds' => $timeoutSeconds,
        ], fn($v) => $v !== null);

        $response = $this->http->post('/browsers', $data);
        return BrowserSession::fromArray($response);
    }

    /**
     * Get information about a browser session (status, URLs).
     *
     * GET /browsers/{session_id}
     *
     * @param string $sessionId The browser session ID (UUID)
     */
    public function get(string $sessionId): BrowserSession
    {
        $response = $this->http->get("/browsers/{$sessionId}");
        return BrowserSession::fromArray($response);
    }

    /**
     * Stop an active browser session.
     *
     * PATCH /browsers/{session_id}
     *
     * @param string $sessionId The browser session ID (UUID)
     * @param string $action The action to perform (currently only 'stop')
     */
    public function update(string $sessionId, string $action = 'stop'): BrowserSession
    {
        $response = $this->http->patch("/browsers/{$sessionId}", [
            'action' => $action,
        ]);
        return BrowserSession::fromArray($response);
    }

    /**
     * Stop a browser session.
     *
     * @param string $sessionId The browser session ID (UUID)
     */
    public function stop(string $sessionId): BrowserSession
    {
        return $this->update($sessionId, 'stop');
    }
}
