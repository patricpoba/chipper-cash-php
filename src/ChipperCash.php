<?php

namespace PatricPoba\ChipperCash;

use GuzzleHttp\Client; 
use PatricPoba\ChipperCash\Http\GuzzleClientAdapter;

class ChipperCash
{
    
    /**
     * Package version
     * @var string 
     */ 
    const VERSION = '1.0';

    /**
     * Chipper configs
     *
     * @var Config
     */
    protected $config;

    
    public function __construct(Config $config)
    {  
        $this->client = new GuzzleClientAdapter( new Client([
            'base_uri'      => $config->getNetworkApiBaseUrl(),
            'headers'       => [ 
                                'x-chipper-user-id'=> $config->getNetworkUserId(), 
                                'x-chipper-api-key'=> $config->getNetworkApiKey() 
                                ],
            'http_errors'   => false,
            'timeout'       => 5
        ]));

        $this->setConfig($config);
    }
    
    
    public function setConfig(Config $config)
    {
        $this->config = $config; 

        return $this;
    }

}
