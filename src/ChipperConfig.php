<?php

namespace PatricPoba\ChipperCash;

use PatricPoba\ChipperCash\Utilities\AttributesMassAssignable;

class ChipperConfig
{
    use AttributesMassAssignable;

    /**
     * base url of network
     * @var string 
     */
    public $networkBaseUrl;
  
    /**
     * User ID of Chipper Merchant Account
     * @var string  
     */
    public $networkUserId;
 
    /**
     * API Key of Chipper Merchant Account
     * @var string 
     */
    public $networkApiKey;
 
    /**
     * associative array containing config as keys and credentials as value
     *
     * @param array $configArray
     */
    public function __construct($configArray = [])
    {
        $this->massAssignAttributes($configArray);
    }

    
    public function getNetworkApiBaseUrl()
    {
        return $this->networkBaseUrl;
    }


    public function getNetworkUserId()
    {
        return $this->networkUserId;
    }


    public function getNetworkApiKey()
    {
        return $this->networkUserId;
    }
    
}
