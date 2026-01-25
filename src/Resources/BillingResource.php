<?php

namespace BrowserUseLaravel\Resources;

use BrowserUseLaravel\DataTransferObjects\AccountBilling;

class BillingResource extends Resource
{
    /**
     * Get authenticated account information including credit balance and account details.
     *
     * GET /billing/account
     */
    public function getAccount(): AccountBilling
    {
        $response = $this->http->get('/billing/account');
        return AccountBilling::fromArray($response);
    }
}
