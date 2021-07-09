<?php

namespace BtEcommerce\BTEposs;

class BTEposs extends EpossCloudRestClient
{
    public function __construct()
    {
        parent::__construct(config('BTEposs.api_user'), config('BTEposs.api_key'));
    }
}
