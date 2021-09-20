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

    const SUPPORTED_CURRENCIES = ['GHS', 'NGN', 'UGX', 'ZAR', 'KSH', 'RWF', 'TZS'];

    /**
     * Chipper configs
     *
     * @var ChipperConfig
     */
    protected $config;

    protected $client;

    
    public function __construct(ChipperConfig $config = null)
    {  
        if ($config) { 
            $this->client = new GuzzleClientAdapter( new Client([
                'base_uri'      => $config->getNetworkApiBaseUrl(),
                'headers'       => [ 
                                    'x-chipper-user-id'=> $config->getNetworkUserId(), 
                                    'x-chipper-api-key'=> $config->getNetworkApiKey() 
                                    ],
                'http_errors'   => false,
                'timeout'       => 5
            ]));
        }else{
            // get config automatically
            
        }

        $this->setConfig($config);
    }
    
    
    public function setConfig(ChipperConfig $config)
    {
        $this->config = $config; 

        return $this;
    }

}
