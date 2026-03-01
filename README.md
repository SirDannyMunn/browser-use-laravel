# BrowserUseLaravel

A Laravel SDK for the Browser Use Cloud API v2. This package provides a clean, fluent interface to interact with all Browser Use Cloud API endpoints using Laravel's native HTTP client.

## Documentation

- [LinkedIn Automation Guide](docs/linkedin-automation.md) - How to automate LinkedIn with Browser Use, including solutions for CAPTCHA and bot detection issues.

## Core Concepts

Core Concepts:
The key product of Browser Use Cloud is the completion of user tasks.

A Session is the complete package of infrastructure Browser Use Cloud provides. Sessions are currently limited to 15 minutes of runtime. A session has a Browser running, and users can run Agents in a session to complete tasks. A Session is limited to one and only one Browser, which will be open the entire duration of the Session. Users can run a maximum of one Agent on a Session at a time, which will control the Browser. After one Agent is done, the user can run another within the same Session, limited only by the Session maximum duration.
A Browser is simply a browser running on Browser Use Cloud infrastructure (a Session). Browsers (as a service) are controllable via CDP url. The user can use an Agent to control a Browser, or can request the CDP url and control the hosted browser with whatever scripts or external automations they desire. However we mainly encourage to control Browsers with Browser Use Agents, as they are optimized to work together. These official Browser Use browsers are forked from chromium, but have a lot of proprietary optimizations made to them so that they are extremely fast and lightweight, untraceable and not detectable as bots, and come preloaded with adblockers and other quality of life. Using Browser Use hosted browsers provides significant performance improvements.
An Agent is the collection of tools, prompts, and framework that enables a Large Language Model to interact with a Browser. The Agents goal is to complete a given user Task. The Agent goes through an iterative process of many steps to complete this. For each step, the Agent is given the page state (including a screenshot) of the Browser, and then it calls tools to interact with the Browser. After many steps, the Agent will mark the task as complete, either successfully or unsuccessfully and return a result, which is a block of text and optionally files. After completion, an independent strict judge will examine the Agent's trajectory and give a verdict of true or false on whether the Agent completed its task successfully. The Agent has a lot of settings which can be tuned to improve performance, most importantly the LLM Model used.
A Model is a Large Language Model that powers an Agent. The smarter and more capable the Model, the better the Agent will perform. The best model to use is ChatBrowserUse, the Browser Use official chat completion API which always routes to the best frontier foundation model as determined by Browser Use internal evaluations. ChatBrowserUse has several speed and cost optimizations done through batching, caching, and other tricks, making it faster and more cost effective than any other option, with identical performance to the top frontier models.
A Browser Profile is a folder of browser data that is saved on our Cloud. If a user creates a Session with a Browser that has no Browser Profile, no data will persist. However, if they use the same Browser Profile across multiple Sessions, then data such as authentication cookies, site local storage data, saved passwords and credentials, and user preferences will persist. A Browser Profile is essentially a cloud hosted Chrome Profile, in fact, through the Profile Upload feature, a user can upload a Chrome profile from their own machine to be used on the Cloud in Sessions. This is great for giving authentication to Agents. A user can create a Chrome profile on their own machine, log into all of the services they want, and then upload this profile to the Cloud for automations.
A Task is the combination of user prompt with optionally files and images that is given to the Agents to complete. Browser Use Cloud primarily sells the completion of user Tasks. Writing Tasks with clarity is key to success.
Profile Sync is the best way to handle authentication for tasks. This feature allows users to upload their local browser cookies (where the user is already logged into the services they need authentication for) to a Browser Profile that can be used for tasks on the cloud. To initiate a Profile Sync, a user must run export BROWSER_USE_API_KEY=<your_key> && curl -fsSL https://browser-use.com/profile.sh | sh and follow the steps in the interactive terminal.


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
    auth: [
        'accounts' => [[
            'provider' => 'linkedin',
            'accountKey' => 'linkedin-account-uuid',
            'requireTotp' => true,
            'minValiditySeconds' => 15,
        ]],
        'enforce' => true,
    ],
);

// Get task details
$task = BrowserUse::tasks()->get('task-uuid');

// Stop a running task
$task = BrowserUse::tasks()->stop('task-uuid');

// Stop task and its session
$task = BrowserUse::tasks()->stopWithSession('task-uuid');

// Get task logs
$logs = BrowserUse::tasks()->getLogs('task-uuid');

// Bulk create tasks (shared session + completion webhook)
$bulk = BrowserUse::tasks()->bulkCreate(
    sessionId: 'session-uuid',
    tasks: [
        ['task' => 'Open linkedin.com/in/alice and send connection request', 'order' => 1],
        ['task' => 'Open linkedin.com/in/bob and send connection request', 'order' => 2],
    ],
    webhookUrl: 'https://velocity.dev/api/v1/lead-outreach/webhooks/phantombrowse-task-complete',
    webhookAuthToken: 'webhook-shared-secret',
    auth: [
        'accounts' => [[
            'provider' => 'linkedin',
            'accountKey' => 'linkedin-account-uuid',
            'requireTotp' => true,
        ]],
        'enforce' => true,
    ],
);
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
