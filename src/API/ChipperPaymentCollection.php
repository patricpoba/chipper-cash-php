<?php

namespace PatricPoba\ChipperCash\API;

use Exception;
use ChipperRequestParametersTrait;
use PatricPoba\ChipperCash\ChipperCash;
use PatricPoba\ChipperCash\Utilities\AttributesMassAssignable;

class ChipperPaymentCollection extends ChipperCash
{ 
    use ChipperRequestParametersTrait, AttributesMassAssignable;

    /**
     * Relative url (segement after base url) for Network Test 
     */
    const API_STANDARD_CHRAGE = 'authorizations';

    const API_AUTOMATIC_CHARGE_AUTHORISATION = 'authorizations';

    const API_AUTOMATIC_CHARGE = 'authorizations/charge/:authorisationId';

    const PAYMENT_TYPE_ONE_TIME = 'ONE_TYPE';

    const PAYMENT_TYPE_LONG_LIVED = 'LONG_LIVED';
   
    public $requireParams = [];
 
    
    /**
     * Execute API request to receive payment via standard charge
     * @param array $params
     * 
     * @throws Exception
     * @return PatricPoba\ChipperCash\Http\ApiResponse
     */ 
    public function collectByStandardCharge(array $params = [])
    {
        $this->massAssignAttributes($params);

        $this->validateRequestParams([
            'recipientIdentifierType',
            'recipientIdentifier',
            'reference',
            'currency',
            'amount',
            'note'
        ]);

        $requestBody = [
            "userId"=> [
                    "type"  => $this->recipientIdentifierType,
                    "value" => $this->recipientIdentifier
                ],
            "scopes"=> ["wallet:charge"],
            "type"=> static::PAYMENT_TYPE_ONE_TIME,
            "order"=> [
                "reference"=> $this->reference,
                "note"=> $this->note,
                "amount"=> [
                    "amount"=> $this->amount,
                    "currency"=> $this->currency
                ]
            ]
        ]; 

        return $this->client->post( static::API_STANDARD_CHRAGE, $requestBody); 
    }

     
    public function getAutomaticChargeAuthorisation(array $params = [])
    {
        $this->massAssignAttributes($params);

        $this->validateRequestParams(['recipientIdentifierType', 'recipientIdentifier']);

        $requestBody = [
            "userId"=> [
                    "type"  => $this->recipientIdentifierType,
                    "value" => $this->recipientIdentifier
                ],
            "scopes"=> ["wallet:charge"],
            "type"=> static::PAYMENT_TYPE_ONE_TIME 
        ]; 

        return $this->client->post( static::API_AUTOMATIC_CHARGE_AUTHORISATION, $requestBody); 
    }


    public function collectByAutomaticCharge(string $authorisationID,  array $params = [])
    {
        $this->massAssignAttributes($params);

        $this->validateRequestParams(['reference', 'note', 'amount', 'currency']);

        $requestBody = [ 
            "order"=> [
                "reference"=> $this->reference,
                "note"=> $this->note,
                "amount"=> [
                    "amount"=> $this->amount,
                    "currency"=> $this->currency
                ]
            ]
        ]; 

        $automaticChargeEndpoint = str_replace(':authorisationId', $authorisationID, static::API_AUTOMATIC_CHARGE);

        return $this->client->post( $automaticChargeEndpoint, $requestBody); 
    }
}
