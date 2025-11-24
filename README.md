# Transact Pro Gateway v3 PHP client library

This library provide ability to make requests to Transact Pro Gateway API v3.

## Installation

Install the latest version with

```bash
$ composer require transact-pro/gw3-client
```

## Basic usage

### Inside form

Hold card input form on gateway side, client must be redirect to gateway.

```php
<?php

use TransactPro\Gateway\Gateway;
use TransactPro\Gateway\Responses\Constants\Status;

$gw = new Gateway('<API BASE URL>/v3.0');

// Setup gateway authorization credentials
$gw->auth()
    ->setAccountGUID("3383e58e-9cde-4ffa-85cf-81cd25b2423e")
    ->setSecretKey('super-secret-key');

// Create transaction object
$sms = $gw->createSms();

// Set required fields
$sms->money()
    ->setAmount(100)
    ->setCurrency('USD');

$sms->customer()
    ->setEmail("email@domain.com")
    ->setPhone("2445224657");

$sms->order()
    ->setMerchantTransactionID('A-345S')
    ->setDescription('Order #A-345S payment');

// Process payment via gateway inside form
$sms->insideForm();

// Build transaction object to request
$smsRequest = $sms->build();

// Process transaction to gateway
$response = $gw->process($smsRequest);

// Parse Gateway response as a payment response
$paymentResponse = $sms->parseResponse($response);
if (!empty($paymentResponse->error)) {
    throw new \RuntimeException("GW error: {$paymentResponse->error->message}");
}

// Redirect user to received URL
if ($paymentResponse->gw->statusCode === Status::CARD_FORM_URL_SENT) {
    header("Location: {$paymentResponse->gw->redirectUrl}");
}
```

### Server to server

Hold card input form on merchant side and process via API.

```php
<?php

use TransactPro\Gateway\Gateway;
use TransactPro\Gateway\Responses\Constants\Status;

$gw = new Gateway('<API BASE URL>/v3.0');

// Setup gatewayl authorization credentials
$gw->auth()
    ->setAccountGUID("3383e58e-9cde-4ffa-85cf-81cd25b2423e")
    ->setSecretKey('super-secret-key');

// Create transaction object
$sms = $gw->createSms();

// Set required fields
$sms->paymentMethod()
    ->setPAN('4295550031781065')
    ->setExpire('06/18')
    ->setCVV('683')
    ->setCardHolderName('John Doe');
$sms->money()
    ->setAmount(100)
    ->setCurrency('USD');

// Build transaction object to request
$smsRequest = $sms->build();

// Process transaction to gateway
$response = $gw->process($smsRequest);

// Parse Gateway response as a payment response
$paymentResponse = $sms->parseResponse($response);
echo $paymentResponse->gw->statusCode === Status::SUCCESS ? "SUCCESS" : "FAILED";
```

## Documentation

This `README` provide introduction to the library usage.

### Operations

Operations are available via `$gw->create<operation name>()` method.

Available operations:
- Transactions
  - CANCEL
  - DMS CHARGE
  - DMS HOLD
  - MOTO DMS
  - MOTO SMS
  - INIT RECURRENT DMS
  - RECURRENT DMS
  - INIT RECURRENT SMS
  - RECURRENT SMS
  - REFUND
  - REVERSAL
  - SMS
  - Credit
  - P2P
  - B2P
- Information
  - HISTORY
  - RECURRENTS
  - REFUNDS
  - RESULT
  - STATUS
  - LIMITS
- Verification
  - 3-D Secure enrollment
  - Complete card verification
- Tokenization
  - Create payment data token
- Callback processing
  - verify callback data sign
- Reporting
  - Get transactions report in CSV format

Pattern to work with the library can be described as follows:

```php
<?php

use TransactPro\Gateway\Gateway;

$gw = new Gateway('<API BASE URL>/v3.0');

// first, you need to setup authorization.
// you can change authorization data in runtime.
// Thus, following operations will work under
// new authorization.
$gw->auth()
    ->setAccountGUID("3383e58e-9cde-4ffa-85cf-81cd25b2423e")
    ->setSecretKey('super-secret-key');

$operation = $gw->createOPERATION();

// here you setup your request through public methods
// that expose you blocks of information, that you can fill for the
// operation of your choice.

// build() will prepare `Request` object that `$gw` will use
// for the request.
$operationRequest = $operation->build();

// process() will perform provided request to the gateway
// `$response` will have response data (headers, body).
$response = $gw->process($operationRequest);

// parse received raw response to an appropriate class
$parsedResponse = $operation->parseResponse($response);
```

### Card verification

```php
<?php

use TransactPro\Gateway\DataSets\Command;

// create a payment to init card verification process
$message->command()->setCardVerificationMode(Command::CARD_VERIFICATION_MODE_INIT);

// complete card verification
$operation = $gw->createCardVerification();
$operation->data()->setGatewayTransactionID($initialResponseGatewayTransactionId);
$operationRequest = $operation->build();
$response = $gw->process($request);
echo $response->getStatusCode() === 200 ? 'SUCCESS' : 'FAILURE';

// send a payment with flag to accept only verified cards
$message->command()->setCardVerificationMode(Command::CARD_VERIFICATION_MODE_VERIFY);
```

### Payment data tokenization

```php
<?php

use TransactPro\Gateway\DataSets\Command;

// option 1: create a payment with flag to save payment data
$message->command()->setPaymentMethodDataSource(Command::DATA_SOURCE_SAVE_TO_GATEWAY);

// option 2: send "create token" request with payment data
$operation = $gw->createToken();
$operation->paymentMethod()
    ->setPAN('<card number>')
    ->setExpire('<card expiry>')
    ->setCardHolderName('<cardholder name>');
$operation->money()
    ->setCurrency('<desired currency>');
$operationRequest = $operation->build();
$response = $gw->process($request);

// send a payment in "token usage" mode with flag to load payment data by token
$message->useToken();
$message->command()
    ->setPaymentMethodDataSource(Command::DATA_SOURCE_USE_GATEWAY_SAVED_CARDHOLDER_INITIATED)
    ->setPaymentMethodDataToken('<initial gateway-transaction-id>');

$response = $gw->process($message);
$paymentResponse = $message->parseResponse($response);
if (
    !empty($paymentResponse->error) &&
    $paymentResponse->error->code === ErrorCode::EEC_ACQUIRER_SOFT_DECLINE &&
    !empty($paymentResponse->gw->redirectUrl)
) {
    header("Location: {$paymentResponse->gw->redirectUrl}");
}
```

### Using alternative payment methods

To use an alternative payment method (like Google Pay), send a received token AS-IS or data from a decrypted token.

```php
<?php

use TransactPro\Gateway\DataSets\Command;

// set a corresponding flag that indicates a token provider
$operation->command()->setPaymentMethodType(Command::PAYMENT_METHOD_TYPE_GOOGLE_PAY);

// option 1: send received token AS-IS
$operation->paymentMethod()->setToken('<token>');

// option 2: send data from decrypted token
$operation->paymentMethod()
    ->setPAN('<card number>')
    ->setExpire('<card expiry>')
    ->setCardHolderName('<cardholder name>') // if available
    ->setExternalTokenCryptogram('<cryptogram from token>') // if available
    ->setExternalTokenECI('<ECI from token>') // if available
    ->setExternalTokenTransStatus('<transStatus from token>') // available for Click to Pay
    ->setExternalTokenDsTransId('<dsTransId from token>') // available for Click to Pay
    ->setExternalTokenAcsTransId('<acsTransId from token>') // available for Click to Pay
    ->setExternalTokenCardHolderAuthenticated($decryptedToken['paymentMethodDetails']['assuranceDetails']['cardHolderAuthenticated']); // for Google Pay
```

### Callback validation

```php
<?php

use TransactPro\Gateway\Responses\GatewayResponse;
use TransactPro\Gateway\Responses\CallbackResult;
use TransactPro\Gateway\Http\Crypto\ResponseDigest;

// verify data digest
$responseDigest = new ResponseDigest($_POST['sign'] ?? '');
$responseDigest->setOriginalUri($paymentResponse->getDigest()->getUri());       // optional, set if available
$responseDigest->setOriginalCnonce($paymentResponse->getDigest()->getCnonce()); // optional, set if available
$responseDigest->setBody($_POST['json'] ?? '');
$responseDigest->verify("3383e58e-9cde-4ffa-85cf-81cd25b2423e", "super-secret-key");

// parse callback data as a payment response
$callbackResponse = GatewayResponse::createFromJSON($_POST['json'] ?? '', CallbackResult::class);
echo $callbackResponse->gw->statusText;
```

### Transactions report loading

```php
<?php

use TransactPro\Gateway\Interfaces\ResponseInterface;

// NB. Merchant GUID/secret must be used instead of account GUID/secret!
$gw->auth()
    ->setMerchantGUID('8D80-921D-BB99-45ED')
    ->setSecretKey('super-secret-key');

$message = $gw->createReport();
$message->filterData()
    ->setDtCreatedFrom(time() - 86400)
    ->setDtFinishedTo(time());

$request = $message->build();
$response = $gw->process($request);

// get raw body
$reportCSV = $response->getBody();

// get parsed body as iterator where each row is an associative array
// with keys from the first line and values are from all other lines
$csvResponse = $message->parseResponse($response);
print_r($csvResponse->getHeaders());
foreach ($csvResponse as $key => $value) {
    print_r($value);
}
```

### Customization

If you need to access different API URL you can set through `Gateway` constructor as follows:

```php
<?php

use TransactPro\Gateway\Gateway;

$gw = new Gateway('https://customurl.com');

```

Also, you can customize client for your needs. By default `Http\Client\Client` class is used. It use cURL under the hood. It implements `HttpClientInterface`. 
You can create your own (or configure default) and set it to the gateway.

```php
<?php

use TransactPro\Gateway\Gateway;

$httpClient = new MyClient(); // implements HttpClientInterface

$gw = new Gateway('<API BASE URL>/v3.0');
$gw->setHttpClient($httpClient);

// use it!
// ...

```

If you need to load an HTML form from Gateway instead of cardholder browser redirect,
a special operation type may be used:

```php
// execute a payment
$paymentResponse = $operation->parseResponse($response);

$retrieveFormOperation = $gw->createRetrieveForm($paymentResponse);
$retrieveFormRequest = $retrieveFormOperation->build();
$htmlResponse = $gw->process($retrieveFormRequest);
$rawHtml = $htmlResponse->getBody();
```

### Exceptions

Main exception, that can be thrown by the library is the `GatewayException`. Following exceptions are children of `GatewayException`:

- `RequestException` - will be thrown if request fail.
- `ValidatorException` - will be thrown if some data for the request is missing.
- `ResponseException` - will be thrown if response parsing/validation fail (corrupted response).
- `DigestMissingException` - will be thrown if response missing Authorization header (corrupted response).
- `DigestMismatchException` - will be thrown if response digest validation fail (corrupted response).

### Useful constants

`\TransactPro\Gateway\Responses\Constants\ErrorCode` - error codes
`\TransactPro\Gateway\Responses\Constants\Status` - transaction statuses
`\TransactPro\Gateway\Responses\Constants\CardFamily` - card families

## About

### Requirements

- This library works with PHP 7.0 or above.

### Submit bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/TransactPRO/gw3-php-client/issues)

### License

This library is licensed under the MIT License - see the `LICENSE` file for details.
