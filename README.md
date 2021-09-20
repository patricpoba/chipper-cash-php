# ChipperCash Network API 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/patricpoba/chipper-cash-php.svg?style=flat-square)](https://packagist.org/packages/patricpoba/chipper-cash-php)
[![GitHub license](https://img.shields.io/github/license/patricpoba/chipper-cash-php?style=flat-square)](https://github.com/patricpoba/chipper-cash-php/blob/master/LICENSE.md)
[![Build Status](https://img.shields.io/travis/patricpoba/chipper-cash-php/master.svg?style=flat-square)](https://travis-ci.org/patricpoba/chipper-cash-php)
[![Quality Score](https://img.shields.io/scrutinizer/g/patricpoba/chipper-cash-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/patricpoba/chipper-cash-php)
[![Total Downloads](https://img.shields.io/packagist/dt/patricpoba/chipper-cash-php.svg?style=flat-square)](https://packagist.org/packages/patricpoba/chipper-cash-php)

This package helps you integrate the [ChipperCash Network API](https://www.notion.so/Chipper-Network-API-Docs-97774c1f1fc741b0b468514aa73d4507) into your Php or Laravel application. 


# Installation 

You are required to have PHP 7.0 or later. You can install the package via composer:

```bash
composer require patricpoba/chipper-cash-php
```

# Configuration
Set your ChipperCash credentials in your `.env` file or where you keep your configurations as shown below. [Check this link to see how to get credentials ](https://www.notion.so/Getting-your-API-credentials-e3517fedc6b3466a9070092e286a42b4)  

```
# trailing slash is a must for the base url
CHIPPER_NETWORK_BASE_URL='https://sandbox.chipper.network/v1/' 
CHIPPER_NETWORK_USER_ID=419832015842
CHIPPER_NETWORK_API_KEY=0845asfjarwrlsfjsalf7908519
```


# Configuration
A configuration object, as shown below, must be passed to the respective class that would be used in the various api calls. If this object is not passed, The credentials set in the `.env` file would be used automatically
 
```php
use PatricPoba\ChipperCash\ChipperConfig;

$config = new ChipperConfig([ 
    // In production, networkBaseUrl is `https://api.chipper.network/v1/` . 
    // Note:the value of networkBaseUrl must end with trailing slash. 
    'networkBaseUrl' => 'https://sandbox.chipper.network/v1/', 
    'networkUserId'  => '123423',
    'networkApiKey'  => 'dddfdd',  
]);
```

# API Usage Guide  

## Network Test
Official documentation here : [Network Test API](https://www.notion.so/Making-your-first-API-request-d0c11802aae445a4bdf3453da48a4f6a)
```php
# Request Example
use PatricPoba\ChipperCash\API\ChipperNetworkTest;

$networkTest = new ChipperNetworkTest();
$resopnse = $networkTest->run();
```

Passing a config object
```php
use PatricPoba\ChipperCash\ChipperConfig;
use PatricPoba\ChipperCash\API\ChipperNetworkTest;

$config = new ChipperConfig([  
    'networkBaseUrl' => 'https://sandbox.chipper.network/v1/', 
    'networkUserId'  => '123423',
    'networkApiKey'  => 'dddfdd',  
]);

$networkTest = new ChipperNetworkTest($config);
$response = $networkTest->run();

# Response Sample

```

## Get Chipper Account Balance
This lets you retrieve your chipper account information including account balance
Official documentation here : [Get your Account Balance API](https://www.notion.so/Get-your-Account-Balance-88571840f2b94b9490259a48619b7a10)
```php 
use PatricPoba\ChipperCash\API\ChipperAccountBalance;

$balanceRequest = new ChipperAccountBalance();
$response = $balanceRequest->run();

# Response Sample

```

## Lookup Chipper User Information
Official documentation here : [Looking up User Information API](https://www.notion.so/Looking-up-User-Information-146f7d5f26aa4234abf402020411ffa6)
```php 
use PatricPoba\ChipperCash\API\ChipperUserLookup;

$request = new ChipperUserLookup();
$response = $request->run();

# Response Sample

```

##  Making Payouts
Official documentation here : [Making Payouts API](https://www.notion.so/Making-Payouts-af5b4c2a4fcf45d4b19024617b2a0d04)
```php
use PatricPoba\ChipperCash\API\ChipperPayout;

$payout = new ChipperPayout();
$response = $payout->recipient('tag', 'johndoe') 
            ->destinationAmount('GHS', '120') // user receives exactly GHS 120
            ->reference('1212121') // must be unique for each request
            ->note('Order 1212121') // short description
            ->run(); // must be called last

 # For Recipient receives the equivalent of the origin amount in their local (primary) currency, use `->originAmount('GHS', '120')` instead of `->destinationAmount('GHS', '120')`
    

# Response Sample

```

## Collecting Payments
Official documentation here : [Collecting Payments API](https://www.notion.so/Collecting-Payments-ff2e1851535141fe8c5cb44c7acfe1f7)
```php
# Request Example


# Response Sample

```

# Api Responses

All API calls return the PatricPoba\ChippeCash\Http\ApiResponse object which is described below:

``` bash
/**
* Data in api response can also be accessed directly from the object.
*/
$response->description // 'description' is in api response.

/**
* Get array format of api response
* @return array
*/
$response->toArray() 

/**
* Get json format of api response
* @return string
*/
$response->toJson() 

/**
* Get the status code of the response
* @return numeric
*/
$response->getStatusCode() 

/**
* Get the headers the response 
*/
$response->getHeaders() 

/**
* Checks if status code in api response was successful ie 200, 201 etc
* return bool
*/
$response->isSuccess() 
```


# Status and Error Types

Official documentation is [avaiable here](https://www.notion.so/Status-and-Error-Types-4ed54d7e4ba047529f55ffe1ad7b93db)



## Testing

``` bash
./vendor/bin/phpunit
```

 
## Contributing

Do you want add a feature or improve this package? Or have you found a bug would like to fix? If yes, I would be glad to receive your pull request.

## Security

If you discover any security related issues, please email poba.dev@outlook.com instead of using the issue tracker.

## Credits

- [Patric Poba](https://github.com/patricpoba)
- [All Contributors](../../contributors)
- [PHP Package Boilerplate](https://laravelpackageboilerplate.com).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
 