<?php
namespace PatricPoba\ChipperCash\API;

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
    public function user(string $identifierType, $identifier )
    {
        $identifierType = strtolower($identifierType);

        if (! in_array($identifierType, ['tag', 'id'])) {
            throw new Exception("recipientIdentifier must be tag or id, {$identifier} given");
        }

        $this->recipientIdentifierType = $identifierType;
        $this->recipientIdentifier = $identifier;

        return $this;
    }

    /** 
     * @param string $identifier
     * @return static
     */
    public function userTag(string $tag)
    {
        return $this->user('tag', $tag);
    }

    /** 
     * @param string $identifier
     * @return static
     */
    public function userId(string $identifier)
    {
        return $this->user('id', $identifier);
    }

    /**
     * Set chipper cash recipient
     *
     * @param string $currency options:ChipperCash::SUPPORTED_CURRENCIES
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
    
    /**
     * Unique id for this transaction. eg order ID
     *
     * @param string $reference
     * @return static
     */
    public function reference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Short description of transaction
     *
     * @param string $note
     * @return static
     */
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
    public function validateRequestParams(array $params = [])
    {
        $missingParams = [];
        $requiredParams = empty($params) ? $this->requiredParams : $params;
        
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
