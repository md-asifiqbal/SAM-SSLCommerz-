# SSLCommerz
[SSLCommerz](https://www.sslcommerz.com) Payment gateway library for Laravel framework. Official documentation is [here](https://developer.sslcommerz.com/docs.html).

## install
```
composer require sam-asif/sslcommerz
```


## Provider

You need to update your application configuration in order to register the package so it can be loaded by Laravel, just update your `config/app.php` file adding the following code at the end of your `'providers'` section:

> `config/app.php`

```php
<?php

return [
    // ...
    'providers' => [
        SamAsif\Sslcommerz\SSLCommerzServiceProvider::class,
        // ...
    ],
    // ...
];
```

### publish
```
php artisan vendor:publish
```
This command will create a `sslcommerz.php` file inside the `config` directory. Configure your parameters in your `.env` file


If your request value contain following key 

```
total_amount
currency
tran_id
cus_name
cus_email
cus_add1
cus_add2
cus_city
cus_state
cus_postcode
cus_country
cus_phone
cus_fax
ship_name
ship_add1
ship_add2
ship_city
ship_state
ship_postcode
ship_phone
ship_country
shipping_method
product_name
product_category
product_profile
value_a
value_b
value_c
value_d
``` 

Then just call the controller method.

```php
<?php

use SamAsif\Sslcommerz\Http\Controllers\SamSSL;


class OrderController extends Controller
{

 public function Order(Request $request)
    {

    	// .......

    	$sslc = new SamSSL();
        $payment_options = $sslc->index($request, 'hosted');



        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

}

```

If your request value dostn't  contain those key, then define an array with those key and call the controller function. 


```php
<?php

use SamAsif\Sslcommerz\Http\Controllers\SamSSL;


class OrderController extends Controller
{

 public function Order(Request $request)
    {

    	$post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique
        // .......
    	

    	$sslc = new SamSSL();
        $payment_options = $sslc->index($post_data, 'hosted');



        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

}

```

