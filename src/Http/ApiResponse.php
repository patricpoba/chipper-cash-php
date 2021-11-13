<?php

namespace PatricPoba\ChipperCash\Http;

use PatricPoba\ChipperCash\Utilities\AttributesMassAssignable;
  

class ApiResponse
{
    use AttributesMassAssignable;
    
    public $headers;
    public $content;
    public $statusCode;

    /**
     * Construct object
     *
     * @param int $statusCode
     * @param string $content
     * @param array $headers
     */
    public function __construct($statusCode, $content, $headers = array())
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->content = $content;

        /**
         * Dynamically create class variables from content array, so content can be accessed directly.
         * eg $response->category, $response->user_id for ['category'=> 'Electronics','user_id'=> 4]
         * $this->content must be set before calling $this->massAssignAttributes()
         */
        // $this->massAssignAttributes($this->toArray());
    }

    /**
     * Get array format of api response
     * @return array
     */
    public function toArray() : array
    {
        return \json_decode($this->content, true);
    }

    /**
     * Get json format of api response
     * @return string
     */
    public function toJson() : string
    {
        return $this->content;
    }

    /**
     * Get the status code of the response
     * @return numeric
     */
    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Checks if api call was successful ie 200, 201 etc
     * return bool
     */
    public function isSuccess() : bool
    {
        return $this->getStatusCode() < 400;
    }
 

    public function __toString()
    {
        return '[HTTP Response]  ' . $this->getStatusCode() . ' ' . $this->content;
    }
}
