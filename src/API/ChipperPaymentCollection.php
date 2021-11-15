<?php

namespace PatricPoba\ChipperCash\API;

use Exception; 
use PatricPoba\ChipperCash\ChipperCash;
use PatricPoba\ChipperCash\Http\ApiResponse;
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

    const API_GET_COLLECTION_URL = 'authorizations/:authorisationId';

    const PAYMENT_TYPE_ONE_TIME = 'ONE_TIME';

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
            "user"=> [
                    "type"  => $this->recipientIdentifierType,
                    $this->recipientIdentifierType => $this->recipientIdentifier
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
            "user"=> [
                    "type"  => $this->recipientIdentifierType,
                    $this->recipientIdentifierType => $this->recipientIdentifier
                ],
            "scopes"=> ["wallet:charge"],
            "type"=> static::PAYMENT_TYPE_LONG_LIVED 
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

    /**
     * Undocumented function
     *
     * @param string $authorisationId
     * @return ApiResponse
     */
    public function getById(string $authorisationId)
    {  
        $url = str_replace(':authorisationId', $authorisationId, static::API_GET_COLLECTION_URL);

        return $this->client->get($url); 
    }
}
