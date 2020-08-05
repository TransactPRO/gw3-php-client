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
