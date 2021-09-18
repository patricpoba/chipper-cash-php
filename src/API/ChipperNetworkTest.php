<?php

namespace PatricPoba\ChipperCash\API;

use PatricPoba\ChipperCash\ChipperCash;

class ChipperNetworkTest extends ChipperCash
{ 
    /**
     * Relative url (segement after base url) for Network Test
     * For - https://api.chipper.network/v1/echo, 
     */
    const API_URL = 'echo';

    public function run()
    {
        return $this->client->get( static::API_URL); 
    }

}
