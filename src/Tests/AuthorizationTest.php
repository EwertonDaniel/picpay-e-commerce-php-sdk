<?php

namespace EwertonDaniel\PicPay\Tests;

use EwertonDaniel\PicPay\Authorization;
use PHPUnit\Framework\TestCase;


class AuthorizationTest extends TestCase
{
    protected Authorization $auth;
    const PICPAY_TOKEN = 'x_picpay_token';
    const SELLER_TOKEN = 'x_seller_token';

    function setUp(): void
    {
        var_dump(__DIR__);
        $this->auth = new Authorization([
            'picpay_token' => self::PICPAY_TOKEN,
            'seller_token' => self::SELLER_TOKEN
        ]);
    }

    function testClientId()
    {
        $attribute = $this->auth->getPicPayToken();
        if ($attribute) print 'x-picpay-token: ' . DisplayColor::success($attribute, true);
        $this->assertNotNull($attribute);
    }

    function testClientSecret()
    {
        $attribute = $this->auth->getSellerToken();
        if ($attribute) print 'x-seller-token: ' . DisplayColor::success($attribute, true);
        $this->assertNotNull($attribute);
    }

    function testCredentialToString()
    {
        $attribute = $this->auth->__toString();
        if ($attribute) {
            print 'Credentials: ' . DisplayColor::success($attribute);
        }
        $this->assertIsString($attribute);
    }
}