<?php

use EwertonDaniel\PicPay\Authorization;
use EwertonDaniel\PicPay\Traits\DisplayColor;
use PHPUnit\Framework\TestCase;

class AuthorizationTest extends TestCase
{
    use DisplayColor;

    protected Authorization $auth;
    const PICPAY_TOKEN = 'x_picpay_token';
    const SELLER_TOKEN = 'x_seller_token';

    function setUp(): void
    {
        $this->auth = new Authorization([
            'picpay_token' => self::PICPAY_TOKEN,
            'seller_token' => self::SELLER_TOKEN
        ]);
    }

    function testClientId()
    {
        $attribute = $this->auth->getPicPayToken();
        if ($attribute) {
            print $this->success('x-picpay-token');
            print $this->information($attribute, true);
        }
        $this->assertNotNull($attribute);
    }

    function testClientSecret()
    {
        $attribute = $this->auth->getSellerToken();
        if ($attribute) {
            print $this->success('x-seller-token');
            print $this->information($attribute, true);
        }
        $this->assertNotNull($attribute);
    }

    function testCredentialToString()
    {
        $attribute = $this->auth->__toString();
        if ($attribute) {
            print  $this->success('Credentials');
            print $this->information($attribute, true);
        }
        $this->assertIsString($attribute);
    }
}