<?php

namespace PatricPoba\ChipperCash\API;

use Exception;
use PatricPoba\ChipperCash\ChipperCash;
use PatricPoba\ChipperCash\Utilities\AttributesMassAssignable;

class ChipperPayout extends ChipperCash
{ 
    use AttributesMassAssignable;

    /**
     * Relative url (segement after base url) for Network Test 
     */
    const API_URL = 'payouts';

    protected $recipientIdentifierType;

    protected $recipientIdentifier;

    protected $reference;

    protected $currency;

    protected $amount;

    protected $note;

    /** 
     * There are two ways the payment amount can be expressed. 
     * - destinationAmount: specifies exactly how much the  recipient should receive 
     * - originAmount: recipeint receives the equivalent of the origin amount in their local (primary) currency. 
     * @docs https://www.notion.so/Making-Payouts-af5b4c2a4fcf45d4b19024617b2a0d04
     * 
     * @var string originAmount|destinationAmount
     */
    protected $payoutOption; 

    public $requireParams = [ 
        'recipientIdentifierType',
        'recipientIdentifier',
        'reference',
        'currency',
        'amount',
        'note',
        'payoutOption',
     ];


    /**
     * Set chipper cash recipient
     *
     * @param string $identifierType
     * @param string|int $identifier
     * @return static
     */
    public function touser(string $identifierType, $identifier )
    {
        $identifierType = strtolower($identifier);

        if (! in_array($identifierType, ['tag', 'id'])) {
            throw new \Exception("recipientIdentifier must be tag or id, {$identifier} given");
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
    protected function amount(string $currency, $amount )
    {
        $currency = ucwords($currency);

        if (! in_array($currency, static::SUPPORTED_CURRENCIES)) {
            $exceptionMessage = "Unsupported currency given - {$currency}. Only these are supported " .
            implode(', ', static::SUPPORTED_CURRENCIES) ;
            throw new \Exception($exceptionMessage);
        }

        if (!is_numeric($amount)) {
            throw new \Exception("Amount must be a numberic value, " . gettype($amount) . " given");
        }

        $this->currency = $currency;
        $this->amount = $amount;

        return $this;
    }

    public function originAmount(string $currency, $amount )
    {
       $this->payoutOption = 'originAmount';
       
       return $this->amount($currency, $amount);
    }

    public function destinationAmount(string $currency, $amount )
    {
       $this->payoutOption = 'destinationAmount';
       
       return $this->amount($currency, $amount);
    }

    public function reference($reference)
    {
        $this->reference = $reference;
    }

    public function note($note)
    {
        $this->note = $note;
    }

    protected function validateRequestParams()
    {
        $missingParams = [];
        foreach ($this->requiredParams as $key => $value) {
            if ($this->{$key} == null) {
                $missingParams[] = $key;
            }
        }

        if ( !empty($missingParams) ) {
            throw new Exception("Error Processing Request");
            exit;
        }
    }
    
    /**
     * Execute API request to make payment
     * @param array $payoutDetails
     * 
     * @throws Exception
     * @return PatricPoba\ChipperCash\Http\ApiResponse
     */
    public function run($payoutDetails = [])
    {
        $this->massAssignAttributes($payoutDetails);

        $this->validateRequestParams();

        $requestBody = [
            "recipientIdentifierType" => $this->recipientIdentifierType,
            "recipientIdentifier" => $this->recipientIdentifier,
            "reference" => $this->reference,
            $this->payoutOption => [
                "amount"  => $this->amount,
                "currency"=> $this->currency
            ],
            "note" => $this->note
        ];

        return $this->client->post( static::API_URL, $requestBody); 
    }

}
