<?php

namespace PatricPoba\Chipper\Network;

use PatricPoba\Chipper\Chipper;

class NetworkTest extends Chipper
{ 

    public function execute()
    {
        return $this->client->get('echo'); 
    }

}
