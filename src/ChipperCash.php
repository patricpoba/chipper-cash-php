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
        $this->setConfig($config); 
    }
    
    /**
     * Set config or override existing config
     *
     * @param ChipperConfig $config
     * @return static
     */
    public function setConfig(ChipperConfig $config=null)
    {
        $this->config = $config; 

         if ($config) {  
            $baseUri = $this->config->getNetworkApiBaseUrl();
            $networkUserId = $this->config->getNetworkUserId();
            $networkApiKey = $this->config->getNetworkApiKey() ; 
        }else{ 
            // get config automatically from environment (laravel)
            
        }
         $this->client = new GuzzleClientAdapter([
                'base_uri' => $baseUri,
                'headers'  => [ 
                    'x-chipper-user-id'=> $networkUserId, 
                    'x-chipper-api-key'=> $networkApiKey 
                ]
            ]);

        return $this;
    }

    /** 
     * Get http client
     * @return GuzzleClientAdapter
     */
    public function getClient()
    {
        return $this->client;
    }

}
