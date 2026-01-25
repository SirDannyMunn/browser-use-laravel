# BrowserUseLaravel

A Laravel SDK for the Browser Use Cloud API v2. This package provides a clean, fluent interface to interact with all Browser Use Cloud API endpoints using Laravel's native HTTP client.

## Installation

Add the package to your `composer.json`:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/BrowserUseLaravel"
        }
    ],
    "require": {
        "velocity/browser-use-laravel": "*"
    }
}
```

Then run:

```bash
composer update
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=browser-use-config
```

Add your API key to your `.env` file:

```env
BROWSER_USE_API_KEY=your-api-key-here
BROWSER_USE_BASE_URL=https://api.browser-use.com/api/v2
BROWSER_USE_TIMEOUT=30
```

## Usage

### Using the Facade

```php
use BrowserUseLaravel\Facades\BrowserUse;

// Get account billing info
$account = BrowserUse::billing()->getAccount();
echo $account->totalCreditsBalanceUsd;

// Create a task
$task = BrowserUse::tasks()->create(
    task: 'Navigate to google.com and search for Laravel',
    startUrl: 'https://google.com',
);
echo "Task ID: {$task->id}";

// Get task status
$taskDetails = BrowserUse::tasks()->get($task->id);
echo "Status: {$taskDetails->status}";
```

### Using Dependency Injection

```php
use BrowserUseLaravel\BrowserUseClient;

class MyController
{
    public function __construct(
        private BrowserUseClient $browserUse
    ) {}

    public function runTask()
    {
        $result = $this->browserUse->tasks()->create(
            task: 'Fill out a form on example.com',
        );
        
        return $result;
    }
}
```

## API Resources

### Billing

```php
// Get account information and credit balance
$account = BrowserUse::billing()->getAccount();
$account->totalCreditsBalanceUsd;
$account->monthlyCreditsBalanceUsd;
$account->additionalCreditsBalanceUsd;
$account->rateLimit;
$account->planInfo->planName;
```

### Tasks

```php
// List tasks with pagination and filtering
$tasks = BrowserUse::tasks()->list(
    pageSize: 20,
    pageNumber: 1,
    sessionId: 'uuid-here',
    filterBy: 'started', // created, started, finished, stopped
    after: '2024-01-01T00:00:00Z',
    before: '2024-12-31T23:59:59Z',
);

// Create a new task
$task = BrowserUse::tasks()->create(
    task: 'Navigate to example.com and click the login button',
    llm: 'gpt-4',
    startUrl: 'https://example.com',
    maxSteps: 30,
    sessionId: null, // Will create new session if null
    metadata: ['key' => 'value'],
    secrets: ['password' => 'secret123'],
    allowedDomains: ['example.com'],
    vision: true,
    judge: true,
    skillIds: ['*'], // Enable all skills
);

// Get task details
$task = BrowserUse::tasks()->get('task-uuid');

// Stop a running task
$task = BrowserUse::tasks()->stop('task-uuid');

// Stop task and its session
$task = BrowserUse::tasks()->stopWithSession('task-uuid');

// Get task logs
$logs = BrowserUse::tasks()->getLogs('task-uuid');
```

### Sessions

```php
// List sessions
$sessions = BrowserUse::sessions()->list(pageSize: 10, pageNumber: 1);

// Create a session
$session = BrowserUse::sessions()->create(
    profileId: 'profile-uuid', // Optional: reuse browser profile
    proxyCountryCode: 'US',
    startUrl: 'https://example.com',
    browserScreenWidth: 1920,
    browserScreenHeight: 1080,
);

// Get session details
$session = BrowserUse::sessions()->get('session-uuid');

// Stop a session
$session = BrowserUse::sessions()->stop('session-uuid');

// Delete a session
BrowserUse::sessions()->delete('session-uuid');

// Public sharing
$share = BrowserUse::sessions()->createPublicShare('session-uuid');
echo $share->shareUrl;

$share = BrowserUse::sessions()->getPublicShare('session-uuid');
BrowserUse::sessions()->deletePublicShare('session-uuid');
```

### Files

```php
// Get presigned URL for uploading to agent session
$presigned = BrowserUse::files()->getAgentSessionUploadUrl(
    sessionId: 'session-uuid',
    fileName: 'document.pdf',
    contentType: 'application/pdf',
    sizeBytes: 102400,
);
// Upload using $presigned->url with $presigned->fields

// Get presigned URL for uploading to browser session
$presigned = BrowserUse::files()->getBrowserSessionUploadUrl(
    sessionId: 'session-uuid',
    fileName: 'image.jpg',
    contentType: 'image/jpeg',
    sizeBytes: 50000,
);

// Get download URL for task output file
$file = BrowserUse::files()->getTaskOutputFileUrl(
    taskId: 'task-uuid',
    fileId: 'file-uuid',
);
echo $file->downloadUrl;
```

### Profiles

```php
// List profiles
$profiles = BrowserUse::profiles()->list(pageSize: 10, pageNumber: 1);

// Create a profile
$profile = BrowserUse::profiles()->create(name: 'My Profile');

// Get profile details
$profile = BrowserUse::profiles()->get('profile-uuid');

// Update profile
$profile = BrowserUse::profiles()->update('profile-uuid', name: 'Updated Name');

// Delete profile
BrowserUse::profiles()->delete('profile-uuid');
```

### Browsers

```php
// List browser sessions
$browsers = BrowserUse::browsers()->list(status: 'active'); // or 'stopped'

// Create a browser session
$browser = BrowserUse::browsers()->create(
    profileId: 'profile-uuid',
    headless: true,
    timeoutSeconds: 300,
);
echo $browser->cdpUrl; // Chrome DevTools Protocol URL
echo $browser->liveUrl; // Live view URL

// Get browser session
$browser = BrowserUse::browsers()->get('session-uuid');

// Stop browser session
$browser = BrowserUse::browsers()->stop('session-uuid');
```

### Skills

```php
// List marketplace skills
$skills = BrowserUse::skills()->listMarketplace(pageSize: 10, pageNumber: 1);

// Clone a skill from marketplace
$skill = BrowserUse::skills()->clone('skill-uuid');

// Execute a skill
$result = BrowserUse::skills()->execute('skill-uuid', [
    'param1' => 'value1',
    'param2' => 'value2',
]);

// Create a custom skill
$skill = BrowserUse::skills()->create(
    title: 'My Custom Skill',
    description: 'Automates something useful',
    goal: 'Login to example.com and download reports',
    categories: ['automation'],
    domains: ['example.com'],
    isPublic: false,
);
```

## Error Handling

The package throws specific exceptions for different error types:

```php
use BrowserUseLaravel\Exceptions\BrowserUseException;
use BrowserUseLaravel\Exceptions\NotFoundException;
use BrowserUseLaravel\Exceptions\ValidationException;
use BrowserUseLaravel\Exceptions\RateLimitException;
use BrowserUseLaravel\Exceptions\AuthenticationException;
use BrowserUseLaravel\Exceptions\PaymentRequiredException;

try {
    $task = BrowserUse::tasks()->get('invalid-uuid');
} catch (NotFoundException $e) {
    // Task not found (404)
} catch (ValidationException $e) {
    // Validation error (422)
    $errors = $e->getErrors();
} catch (RateLimitException $e) {
    // Rate limited (429)
} catch (AuthenticationException $e) {
    // Invalid API key (401/403)
} catch (PaymentRequiredException $e) {
    // Insufficient credits (402)
} catch (BrowserUseException $e) {
    // Other API errors
    $statusCode = $e->getStatusCode();
}
```

## Data Transfer Objects

All API responses are returned as typed DTOs with helper methods:

```php
$task = BrowserUse::tasks()->get('uuid');
$task->isRunning();   // true if status is 'created' or 'started'
$task->isCompleted(); // true if status is 'finished' or 'stopped'

$session = BrowserUse::sessions()->get('uuid');
$session->isActive();
$session->isStopped();

$taskList = BrowserUse::tasks()->list();
$taskList->hasMore();     // More pages available?
$taskList->totalPages();  // Total number of pages
```

## License

MIT
