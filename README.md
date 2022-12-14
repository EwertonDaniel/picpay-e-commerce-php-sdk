[![Generic badge](https://img.shields.io/github/last-commit/ewertondaniel/picpay-e-commerce-php-sdk)](https://github.com/EwertonDaniel/picpay-e-commerce-php-sdk)
[![Generic badge](https://img.shields.io/badge/stable-v1.0.7-blue.svg)](https://github.com/EwertonDaniel/picpay-e-commerce-php-sdk)
[![GitHub license](https://img.shields.io/github/license/ewertondaniel/picpay-e-commerce-php-sdk)](https://github.com/Naereen/StrapDown.js/blob/master/LICENSE)
[![Generic badge](https://img.shields.io/packagist/dm/ewertondaniel/picpay-e-commerce-php-sdk?color=blue)](https://packagist.org/packages/ewertondaniel/picpay-e-commerce-php-sdk)
[![Twitter](https://img.shields.io/twitter/follow/dsrewerton?style=social)](https://twitter.com/dsrewerton)


# π PicPay E-Commerce API Integration π§π·

_This library provides developers with a simple set of bindings to help you
integrate [PicPay E-Commerce API](https://studio.picpay.com/produtos/e-commerce) to a website
and start receiving payments._

## π  Requirements

`php >= 8.1`

`guzzlehttp/guzzle >= 7.0.1`

`echosistema/simple-http-request" >= 1.0.1`

π’ **Coming soon package to `PHP versions < 8.1`.**

## π» Installation

First time using PicPay? Create your PicPay account in [PicPay Studio](https://studio.picpay.com/download), if you donβt
have one already.

Download [Composer](https://getcomposer.org/) if not already installed

On your project directory run on the command line `"composer require ewertondaniel/picpay-e-commerce-php-sdk"`
for `PHP 8.1`;

That's it! **PicPay E-Commerce** has been successfully installed!

## π§βπ» Examples

### π€ Create a Customer/Buyer to Payment Order

```php

use EwertonDaniel\PicPay\Customer;

  /**
   * Brazilian CPF and Phone Number can be only numbers or with default mask;
   * The email and phone number fields are optional;
   */
  
        $customer = new Customer();
        $customer->setFirstName('Anakin') // REQUIRED;
            ->setLastName('Skywalker') // REQUIRED;
            ->setEmail('anakin@jediorder.com')) // Optional;
            ->setPhoneNumber('11987654321'))  // Optional;
            ->setDocument('963.237.510-62');  // REQUIRED, Has a CPF validation rule;
            
```

### π² Create a Payment Order

```php

use EwertonDaniel\PicPay\PicPay;

        $payment = new PicPay('x_picpay_token');
        $payment
            ->setCustomer([
                'first_name' => 'Din',
                'last_name' => 'Djarin',
                'document' => '963.237.510-62'
            ]) // REQUIRED, Array or Customer class;
            ->setReferenceId('MY-ID-0001') //string, call REQUIRED, If you want an auto reference id, please call empty ex.: setReferenceId();
            ->setCallbackUrl('https://my-website.com/notification')  // REQUIRED, Where PicPay will return with POST notification;
            ->setValue(100.00) //float, REQUIRED;
            ->pay();
            
```

### π² Create a Full Payment Order

```php

use EwertonDaniel\PicPay\PicPay;

        $payment = new PicPay('x_picpay_token');
        $payment
            ->setCustomer([
                'first_name' => 'Din',
                'last_name' => 'Djarin',
                'document' => '963.237.510-62', // It can just be numbers ex.: '96323751062'
                'email'=>'din@mandalorian.com', // Optional
                'phone_number'=>'11987654321' // Optional, It can just be masked ex.: '(11) 98765-4321, (11) 8765-4321 etc...'
            ]) // REQUIRED, Array or Customer class;
            ->setDebug(false) // Optional, (default:false) If you want to debug the request (default false);
            ->setReferenceId('MY-ID-0002') //string, call REQUIRED, If no value is entered, Reference ID will be created automatically, ex.: setReferenceId();
            ->setCallbackUrl('https://my-website.com/notification')  // REQUIRED, Where PicPay will return with POST notification;
            ->setReturnUrl('https://my-website.com/order/MY-ID-0002')  // Optional, (default:null) where customer will be redirected from PicPay Payment Page;
            ->setExpirationDate('2020-09-20') // Optional, (default:null) Format Y-m-d (yyyy-mm-dd);
            ->setSoftDescriptor('Skywalker light-saber') // Optional, (default:null) The soft descriptor is the dynamic text used to construct the statement descriptor that appears on a payer's card statement;
            ->setPurchaseMode('online') // Optional, (default: online, available options [online, in-store]);
            ->setChannel('channel') // Optional, (default:null) If you have another store, take a look in official documentation;
            ->setAutoCapture(true) // Optional, (default:true) Key that will define that this charge will be of the late capture type;
            ->setValue(100.00) //float, REQUIRED
            ->pay()
            
```

### βΉ Get a specific Order Status

```php

use EwertonDaniel\PicPay\Order;

        $order = new Order('x_picpay_token','reference_id');
        $response = $order->status();
        $status =  $response['status'];

```

#### Possibles status response when request Order Status:

<dl>
  <dd>β created: order created;</dd>
  <dd>β expired: payment limit date has expired or order cancelled;</dd>
  <dd>β analysis: paid and in the process of anti-fraud analysis;</dd>
  <dd>β completed: paid and amount available in your PicPay account;</dd>
  <dd>β refunded: paid and refunded;</dd>
  <dd>β chargeback: paid with chargeback;</dd>
</dl>

### β Cancel a specific Order

```php

use EwertonDaniel\PicPay\Order;

       $order = new Order('x_picpay_token','reference_id');
       $response = $order->cancel();
       $status = $response['status'];

```

#### Possibles cancellation status response:

<dl>
  <dd>β cancelled: order cancelled;</dd>
  <dd>β undefined: unknown status;</dd>
</dl>

## π Documentation

### π Visit the PicPay Studio for further information regarding:

[PicPay E-Commerce Official Documentation](https://studio.picpay.com/produtos/e-commerce)
