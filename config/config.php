<?php

/*
 * You can place your custom package configuration in here.
 */
return [

    /**
     * Trailing slash is a must for base_url_*
     * https://docs.guzzlephp.org/en/stable/quickstart.html?highlight=base%20url
     */
    'base_url'   => env('CHIPPER_NETWORK_BASE_URL', 'https://sandbox.chipper.network/v1/'),
 
    'network_user_id'=> env('CHIPPER_NETWORK_USER_ID'),
    
    'network_api_key'=> env('CHIPPER_NETWORK_API_KEY')

]; 