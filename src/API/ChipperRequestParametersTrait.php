<?php

use Exception;
use PatricPoba\ChipperCash\ChipperCash;

trait ChipperRequestParametersTrait  
{ 
    protected $recipientIdentifierType;

    protected $recipientIdentifier;

    /**
     * Must be unique. eg order id
     *
     * @var string
     */
    protected $reference;

    protected $currency;

    protected $amount;

    protected $note;


    /**
     * Set chipper cash recipient
     * @param string $identifierType
     * @param string|int $identifier
     * 
     * @throws Exception
     * @return static
     */
    public function recipient(string $identifierType, $identifier )
    {
        $identifierType = strtolower($identifier);

        if (! in_array($identifierType, ['tag', 'id'])) {
            throw new Exception("recipientIdentifier must be tag or id, {$identifier} given");
        }

        $this->recipientIdentifierType = $identifierType;
        $this->recipientIdentifier = $identifier;

        return $this;
    }

    /**
     * Set chipper cash recipient
     *
     * @param string $identifierType
     * @param string|int $identifier
     * @return static
     */
    public function amount(string $currency, $amount )
    {
        $currency = ucwords($currency);

        if (! in_array($currency, ChipperCash::SUPPORTED_CURRENCIES)) {
            $exceptionMessage = "Unsupported currency given - {$currency}. Only these are supported " .
            implode(', ', ChipperCash::SUPPORTED_CURRENCIES) ;
            throw new \Exception($exceptionMessage);
        }

        if (!is_numeric($amount)) {
            throw new \Exception("Amount must be a numberic value, " . gettype($amount) . " given");
        }

        $this->currency = $currency;
        $this->amount = $amount;

        return $this;
    }
 
    public function reference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    public function note($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * validate the request params
     *
     * @param array $param 
     */
    public function validateRequestParams(array $param = [])
    {
        $missingParams = [];
        $requiredParams = empty($param) ? $this->requiredParams : $param;
        
        foreach ($requiredParams as $key ) {
            if ($this->{$key} == null) {
                $missingParams[] = $key;
            }
        }

        if ( !empty($missingParams) ) {
            throw new Exception("Missing required params: " . implode(', ', $missingParams) ); 
        }

        return $this;
    }

}
