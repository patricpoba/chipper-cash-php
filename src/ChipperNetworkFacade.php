<?php

namespace PatricPoba\ChipperNetwork;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PatricPoba\ChipperNetwork\Skeleton\SkeletonClass
 */
class ChipperNetworkFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chipper-network';
    }
}
