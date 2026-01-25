<?php

namespace BrowserUseLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use BrowserUseLaravel\BrowserUseClient;
use BrowserUseLaravel\Resources\BillingResource;
use BrowserUseLaravel\Resources\TasksResource;
use BrowserUseLaravel\Resources\SessionsResource;
use BrowserUseLaravel\Resources\FilesResource;
use BrowserUseLaravel\Resources\ProfilesResource;
use BrowserUseLaravel\Resources\BrowsersResource;
use BrowserUseLaravel\Resources\SkillsResource;

/**
 * @method static BillingResource billing()
 * @method static TasksResource tasks()
 * @method static SessionsResource sessions()
 * @method static FilesResource files()
 * @method static ProfilesResource profiles()
 * @method static BrowsersResource browsers()
 * @method static SkillsResource skills()
 *
 * @see \BrowserUseLaravel\BrowserUseClient
 */
class BrowserUse extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BrowserUseClient::class;
    }
}
