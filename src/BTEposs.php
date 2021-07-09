<?php

namespace BtEcommerce\BTEposs;

class BTEposs extends EpossCloudRestClient
{
    public function __construct()
    {
        parent::__construct(config('bteposs.api_user'), config('bteposs.api_key'));
    }
}
