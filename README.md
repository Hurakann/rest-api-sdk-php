rest-api-sdk-php
=================

Hover API Rest SDK for PHP

Welcome to the Hover SDK for PHP, this SDK is for building a robust PHP application based on the Hover API. The Hover SDK for PHP makes it easy to integrate a full Hover API services into PHP apps. 

SDK Integration
===============

In order to integrate the SDK into your PHP project just clone this repo and use the single class helper provided.

To use the SDK follow the next steps:

* Add class `class-TheHover-v1.php` to your app.

* Require `class-TheHover-v1.php` in your script

	```php
		require_once ('class-TheHover-v1.php');	
	```
	
* Configure SDK, by providing the required parameters:

	```php
		$thehover = new TheHover($clientKey, $url, 'json');
	```

	All configure options available are:
	
	* $clientKey - your client secret token to access the API
	* $url - the dns or ip for The Hover API (default to our sandbox cloud) 
	* 'json' - must always be json for v1
	
* Invoke API

	```php
		<?php
			require_once ('class-TheHover-v1.php');

			$clientKey = 'yourclientkey';

			$data = array('branch_id' => 'YourBranchId', 'user_id' => 'YourUserId', 'phase' => 'all');

			$thehover = new TheHover($clientKey, $url, 'json');

			$result = $thehover->usersFetch($data);

			print_r($result);

		?>	
	```

About
=====

You can find more info about courses of how to use the API, SDKs or integration of The Hover into your app,
visiting us at: http://www.thehover.com or mail us: thehover@hovanetworks.com
