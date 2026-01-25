# LinkedIn Automation Guide

This guide documents how to use BrowserUseLaravel for LinkedIn automation, including solutions for common issues like CAPTCHAs and bot detection.

## Overview

LinkedIn has sophisticated bot detection that can block automated logins. This guide provides a working approach that avoids these issues.

## Key Findings

### What Works ✅

1. **Use `sessions()->create()` instead of `browsers()->create()`**
   - Sessions work properly with the live viewer
   - Browsers resource had issues loading

2. **Use lowercase country codes**
   - The API requires ISO 3166-1 alpha-2 codes in **lowercase**
   - ✅ `'us'` - Works
   - ❌ `'US'` - Returns 422 validation error

3. **Use `proxyCountryCode` parameter**
   - This helps with anti-bot detection
   - Routes through residential proxies

4. **Use Browser Profiles for session persistence**
   - Create a profile once, reuse across sessions
   - Cookies and login state persist

### What Doesn't Work ❌

1. **Automated login with CAPTCHA**
   - LinkedIn presents security challenges for automated logins
   - Even with valid credentials and TOTP, CAPTCHAs block access

2. **`browsers()->create()` endpoint**
   - Live viewer doesn't load properly
   - Use sessions instead

## Recommended Approach: Manual First Login

The most reliable approach is:

1. Create a session with a profile
2. User logs in manually via the live viewer
3. Session saves cookies to the profile
4. Future automations use the saved profile (already logged in)

## Implementation

### Step 1: Create a Browser Profile

```php
use BrowserUseLaravel\Facades\BrowserUse;

// Create a reusable profile
$profile = BrowserUse::profiles()->create(
    name: 'LinkedIn - My Account'
);

// Save the profile ID for future use
$profileId = $profile->id;
```

### Step 2: Start Manual Login Session

```php
// Create a session with the profile
$session = BrowserUse::sessions()->create(
    profileId: $profileId,
    proxyCountryCode: 'us',  // MUST be lowercase!
    startUrl: 'https://www.linkedin.com/login'
);

echo "Open this URL in your browser:\n";
echo $session->liveUrl;

// The session ID for later use
$sessionId = $session->id;
```

### Step 3: User Logs In Manually

Open the `liveUrl` in your browser. You'll see the LinkedIn login page. Log in with your credentials (including 2FA if enabled). The session persists for up to 15 minutes.

### Step 4: Close Session to Save Profile

```php
// Delete the session - this saves cookies to the profile
BrowserUse::sessions()->delete($sessionId);

// Wait a moment for profile to save
sleep(2);
```

### Step 5: Verify Login and Run Automations

```php
// Create a new session with the same profile
$session = BrowserUse::sessions()->create(
    profileId: $profileId,
    proxyCountryCode: 'us',
    startUrl: 'https://www.linkedin.com/feed/'
);

// Create a task to verify login
$task = BrowserUse::tasks()->create(
    task: 'Check if logged in. If you see the feed, return "LOGGED_IN". Otherwise "NOT_LOGGED_IN".',
    sessionId: $session->id,
    maxSteps: 10,
    vision: true,
);

// Poll for completion
do {
    sleep(5);
    $taskDetails = BrowserUse::tasks()->get($task->id);
} while (!$taskDetails->isCompleted());

echo "Result: " . $taskDetails->output;
```

## Complete Example: LinkedIn Automation Service

Here's a complete service class implementation:

```php
<?php

namespace App\Services;

use BrowserUseLaravel\BrowserUseClient;

class LinkedInAutomationService
{
    protected BrowserUseClient $browserUse;
    protected ?string $profileId = null;

    public function __construct(BrowserUseClient $browserUse)
    {
        $this->browserUse = $browserUse;
    }

    /**
     * Get or create a browser profile for LinkedIn.
     */
    public function getOrCreateProfile(string $name): string
    {
        if ($this->profileId) {
            return $this->profileId;
        }

        $profile = $this->browserUse->profiles()->create(
            name: "LinkedIn - {$name}"
        );

        $this->profileId = $profile->id;
        return $profile->id;
    }

    /**
     * Start a session for manual login.
     * Returns the live URL for the user to access.
     */
    public function startManualLoginSession(string $profileId): array
    {
        $session = $this->browserUse->sessions()->create(
            profileId: $profileId,
            proxyCountryCode: 'us',  // MUST be lowercase
            startUrl: 'https://www.linkedin.com/login'
        );

        return [
            'session_id' => $session->id,
            'live_url' => $session->liveUrl,
            'timeout_seconds' => 900, // 15 minute max
        ];
    }

    /**
     * Complete login and save profile state.
     */
    public function completeLogin(string $sessionId): bool
    {
        try {
            $this->browserUse->sessions()->delete($sessionId);
            sleep(2); // Wait for profile to save
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if we're logged into LinkedIn.
     */
    public function checkLoginStatus(string $profileId): bool
    {
        $session = $this->browserUse->sessions()->create(
            profileId: $profileId,
            proxyCountryCode: 'us',
            startUrl: 'https://www.linkedin.com/feed/'
        );

        $task = $this->browserUse->tasks()->create(
            task: 'Look at the page. If you see a LinkedIn feed with posts, return "LOGGED_IN". If you see a login page, return "NOT_LOGGED_IN".',
            sessionId: $session->id,
            maxSteps: 10,
            vision: true,
        );

        // Wait for task completion
        $result = $this->waitForTask($task->id);

        // Cleanup
        try {
            $this->browserUse->sessions()->delete($session->id);
        } catch (\Exception $e) {
            // Ignore
        }

        return str_contains(strtoupper($result), 'LOGGED_IN')
            && !str_contains(strtoupper($result), 'NOT_LOGGED_IN');
    }

    /**
     * Run a LinkedIn task (requires logged-in profile).
     */
    public function runTask(string $profileId, string $taskPrompt): string
    {
        $session = $this->browserUse->sessions()->create(
            profileId: $profileId,
            proxyCountryCode: 'us',
            startUrl: 'https://www.linkedin.com/'
        );

        $task = $this->browserUse->tasks()->create(
            task: $taskPrompt,
            sessionId: $session->id,
            maxSteps: 50,
            allowedDomains: ['linkedin.com', 'www.linkedin.com'],
            vision: true,
        );

        $output = $this->waitForTask($task->id);

        try {
            $this->browserUse->sessions()->delete($session->id);
        } catch (\Exception $e) {
            // Ignore
        }

        return $output;
    }

    /**
     * Wait for task completion and return output.
     */
    protected function waitForTask(string $taskId, int $timeoutSeconds = 300): string
    {
        $startTime = time();

        while (true) {
            $task = $this->browserUse->tasks()->get($taskId);

            if ($task->isCompleted()) {
                return $task->output ?? '';
            }

            if ((time() - $startTime) > $timeoutSeconds) {
                try {
                    $this->browserUse->tasks()->stop($taskId);
                } catch (\Exception $e) {
                    // Ignore
                }
                throw new \RuntimeException('Task timed out');
            }

            sleep(5);
        }
    }
}
```

## CLI Scripts for Testing

### Manual Connect Script

```php
<?php
// tinker/debug/linkedin_manual_connect.php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use BrowserUseLaravel\Facades\BrowserUse;

// Create or get profile
$profile = BrowserUse::profiles()->create(name: 'LinkedIn - Test');

// Create session
$session = BrowserUse::sessions()->create(
    profileId: $profile->id,
    proxyCountryCode: 'us',
    startUrl: 'https://www.linkedin.com/login'
);

echo "Profile ID: {$profile->id}\n";
echo "Session ID: {$session->id}\n";
echo "\nOpen this URL:\n{$session->liveUrl}\n";
echo "\nAfter logging in, run linkedin_confirm_connection.php\n";
```

### Confirm Connection Script

```php
<?php
// tinker/debug/linkedin_confirm_connection.php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use BrowserUseLaravel\Facades\BrowserUse;

$profileId = 'YOUR_PROFILE_ID';  // From manual connect

// Delete session to save profile
// BrowserUse::sessions()->delete($sessionId);

// Create new session to verify
$session = BrowserUse::sessions()->create(
    profileId: $profileId,
    proxyCountryCode: 'us',
    startUrl: 'https://www.linkedin.com/feed/'
);

$task = BrowserUse::tasks()->create(
    task: 'Are we logged in? Return LOGGED_IN or NOT_LOGGED_IN.',
    sessionId: $session->id,
    maxSteps: 10,
    vision: true,
);

// Wait for result
do {
    sleep(5);
    $taskDetails = BrowserUse::tasks()->get($task->id);
} while (!$taskDetails->isCompleted());

echo "Result: {$taskDetails->output}\n";

BrowserUse::sessions()->delete($session->id);
```

## Common Issues

### 422 Validation Error on proxyCountryCode

**Problem:** API returns validation error for country code.

**Solution:** Use lowercase ISO codes: `'us'` not `'US'`.

### Live URL Doesn't Load

**Problem:** Opening the liveUrl shows blank page or connection error.

**Solution:** Use `sessions()->create()` instead of `browsers()->create()`.

### CAPTCHA on Automated Login

**Problem:** LinkedIn shows security challenge when trying to automate login.

**Solution:** Use manual login approach. Log in once manually, then use the saved profile for automation.

### Session Times Out

**Problem:** Session expires while user is logging in.

**Solution:** Sessions have a 15-minute limit. Start the login process immediately after creating the session.

## TOTP (2FA) Handling

If the account has 2FA enabled, generate a fresh code:

```php
// Ensure TOTP code has at least 10 seconds validity
$secondsRemaining = 30 - (time() % 30);

if ($secondsRemaining < 10) {
    sleep($secondsRemaining + 1);
}

// Generate code (using OTPHP library or similar)
$totp = \OTPHP\TOTP::createFromSecret($totpSecret);
$code = $totp->now();

echo "TOTP Code: {$code}\n";
echo "Valid for: " . (30 - (time() % 30)) . " seconds\n";
```

## Best Practices

1. **Always use profiles** - Don't create throwaway sessions
2. **Lowercase country codes** - Required by the API
3. **Use sessions, not browsers** - Sessions work better with live viewer
4. **Manual first login** - Avoids CAPTCHA issues
5. **Store profile IDs** - Persist them for reuse across sessions
6. **Handle timeouts** - Sessions expire after 15 minutes
7. **Wait for TOTP validity** - Ensure at least 10 seconds remaining

## Rate Limits

Browser Use has concurrency limits. If you get "too many concurrent sessions" errors, wait for existing sessions to complete or delete them:

```php
// Get all sessions
$sessions = BrowserUse::sessions()->list();

// Delete old sessions
foreach ($sessions->items as $session) {
    if ($session->status === 'active') {
        BrowserUse::sessions()->delete($session->id);
    }
}
```
