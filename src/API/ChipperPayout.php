<?php

namespace PatricPoba\ChipperCash\API;

use Exception;
use ChipperRequestParametersTrait;
use PatricPoba\ChipperCash\ChipperCash;
use PatricPoba\ChipperCash\Utilities\AttributesMassAssignable;

class ChipperPayout extends ChipperCash
{ 
    use ChipperRequestParametersTrait, AttributesMassAssignable;

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
    
    /**
     * Execute API request to make payment
     * @param array $payoutDetails overrides previously set attributes
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
