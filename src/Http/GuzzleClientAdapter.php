<?php
 
namespace PatricPoba\ChipperCash\Http;

use Exception; 
use GuzzleHttp\ClientInterface; 

class GuzzleClientAdapter implements HttpClientInterface
{
    /**
     * @var ClientInterface
     */
    public $client;

    /**
     * Base url of api collection
     *
     * @var string
     */
    public $baseUrl;


    public function __construct( ClientInterface $client)
    {  
        $this->client = $client ;
    }
 
    /**
     * Make an http request
     *
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return \PatricPoba\ChipperCash\Http\ApiResponse
     */
    public function request($method, $url, $params = [], $headers = [])
    {
        try {
            // $response = $this->client->send(
            //     new \GuzzleHttp\Psr7\Request\Request($method, $url, $headers), ['json' => $params]
            // );

            $response = $this->client->request($method, $url, [
                'headers' => $headers,
                'json' => $params
            ]);
 
        } catch (\Exception $exception) {
            throw new Exception("HTTP request failed: {$url} " . $exception->getMessage(), null, $exception); 
        }

        // Casting the body (stream) to a string performs a rewind, ensuring we return the entire response.
        // See https://stackoverflow.com/a/30549372/86696
        return new ApiResponse($response->getStatusCode(), (string) $response->getBody(), $response->getHeaders());
    }
    

    public function get($url, $params = [], $headers = [])
    {
        return $this->request('GET', $url, $params, $headers);
    }

    
    public function post($url, $params = [], $headers = [])
    {
        return $this->request('POST', $url, $params, $headers);
    }
 
}
