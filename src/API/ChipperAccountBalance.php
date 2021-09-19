<?php

namespace PatricPoba\ChipperCash\API;

use PatricPoba\ChipperCash\ChipperCash;

class ChipperAccountBalance extends ChipperCash
{ 
    /**
     * Relative url (segement after base url) for Network Test 
     */
    const API_URL = 'users/me';

    public function run()
    {
        return $this->client->get( static::API_URL); 
    }

}
