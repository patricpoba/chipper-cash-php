<?php

namespace PatricPoba\ChipperCash\API;

use PatricPoba\ChipperCash\ChipperCash;
 

class ChipperUserLookup extends ChipperCash
{ 
    /**
     * Relative url (segement after base url) for Network Test
     * For - https://api.chipper.network/v1/echo, 
     */
    const API_URL = 'users/lookup';

    public function execute($type, $typeValue)
    { 
        return $this->client->post( static::API_URL, [
            'type'  => $type,
            $type   => $typeValue
        ]);  
    }

    public function byEmail($email)
    {
        return $this->execute('email', $email);
    }

    public function byTag($tag)
    {
        return $this->execute('tag', $tag);
    }

    public function byPhone($phone)
    {
        return $this->execute('phone', $phone);
    }

}
