##### Version 2.0.7 (2025-11-24)

	Add alternative payment methods support (like Google Pay)

##### Version 2.0.6 (2024-10-02)

	Add crypto data expired error code

##### Version 2.0.5 (2023-11-08)

	Added new fields for order data to satisfy AN5524 requirements:
	 - mits-expected: must be set to true for UCOF initialization if any subsequent MIT transactions are supposed to be
	 - variable-amount-recurring: must be set to true for initial recurring transaction if amount will not be fixed for subsequent transactions

##### Version 2.0.4 (2022-11-21)

	Fix PHP 8.1 warnings
	PHP 7.1 is no longer supported (in fact, everything less than 7.4 must not be used due to security reasons)
	Added support for external 3-D Secure. Added methods for PaymentMethod object (when 3-D Secure was completed before the Gateway call):
	 - setExternalMpiProtocolVersion
	 - setExternalMpiDsTransID
	 - setExternalMpiXID
	 - setExternalMpiCAVV
	 - setExternalMpiTransStatus

##### Version 2.0.4 (2022-11-21)

	Fix PHP 8.1 warnings
	PHP 7.1 is no longer supported (in fact, everything less than 7.4 must not be used due to security reasons)
	Added support for external 3-D Secure. Added methods for PaymentMethod object (when 3-D Secure was completed before the Gateway call):
	 - setExternalMpiProtocolVersion
	 - setExternalMpiDsTransID
	 - setExternalMpiXID
	 - setExternalMpiCAVV
	 - setExternalMpiTransStatus

##### Version 2.0.3 (2021-09-21)

	Added card type and card mask fields to parsed status response.

##### Version 2.0.2 (2021-09-06)

	Added fields for recurring payments: recurring-frequency and recurring expiry.

##### Version 2.0.1 (2021-06-04)

	Added error codes for soft declines support

##### Version 2.0.0 (2021-04-23)

        Add PHP 8 support in composer.json
        Drop PHP 7.0 support

##### Version 1.7.2 (2020-09-02)

	Add merchant-transaction-id to payment response parsing
	Affected:
	 - payment response
	 - result response
	 - callback parsing

##### Version 1.7.1 (2020-08-05)

	Add parameters describing cardholder device

##### Version 1.7.0 (2020-07-03)

	Improve authorization to use digest instead of API key.
	Verify non-failed responses for valid digest.
	Add possibility to validate callback data.
	Implement /report method.
	Implement response parsing.

##### Version 1.6.0 (2020-02-25)

	Add possibility to use custom return URL

##### Version 1.5.0 (2019-07-17)

	Add payment data tokenization methods

##### Version 1.4.1 (2019-05-10)

	Add information about inside form in basic usage

##### Version 1.4.0 (2019-05-09)

	Add card verification request.

##### Version 1.3.3 (2019-03-21)

	Add support of custom 3D Secure return url

##### Version 1.3.2 (2019-03-04)

	Add merchant-referring-name fields to an order.

##### Version 1.3.1 (2019-01-23)

	Added possibility to send mercahnt transaction ID for some methods to meet
	GW requirements
	
	Affected methods:
	 - DMS Hold cancel
	 - DMS Hold Charge
	 - Refund
	 - Reversal

##### Version 1.2.0 (2018-08-21)

	Added order information for subsequent requrring payments to pass field merchant-transaction-id
	Added new method B2P (Business To Person)
	Added new method for card 3-D Secure enrollment verification

##### Version 1.1.1 (2018-02-27)

	Minor fixes

##### Version 1.1.0 (2018-01-22)

	Add new methods for init recurrent SMS and init recurrent DMS

##### Version 1.0.0 (2017-11-10)

	First release
