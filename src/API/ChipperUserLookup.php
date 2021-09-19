<?php

namespace PatricPoba\ChipperCash\API;

use PatricPoba\ChipperCash\ChipperCash;
 

class ChipperUserLookup extends ChipperCash
{ 
    /**
     * Relative url (segement after base url) for Network Test 
     */
    const API_URL = 'users/lookup';


    public function run($type, $typeValue)
    { 
        return $this->client->post( static::API_URL, [
            'type'  => $type,
            $type   => $typeValue
        ]);  
    }


    public function byEmail(string $email)
    {
        return $this->run('email', $email);
    }


    public function byTag(string $tag)
    {
        return $this->run('tag', $tag);
    }


    public function byPhone(string $phone)
    {
        return $this->run('phone', $phone);
    }


    public function byId(int $id)
    {
        return $this->run('id', $id);
    }

}
