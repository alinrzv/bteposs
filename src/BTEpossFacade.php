<?php

namespace BtEcommerce\BTEposs;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BtEcommerce\BTEposs\Skeleton\SkeletonClass
 */
class BTEpossFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bteposs';
    }
}
