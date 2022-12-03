<?php

namespace EwertonDaniel\PicPay\Tests;

use EwertonDaniel\PicPay\Exceptions\CustomerException;
use EwertonDaniel\PicPay\Exceptions\PaymentException;
use EwertonDaniel\PicPay\PicPay;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class PicPayTest extends TestCase
{
    const PICPAY_TOKEN = 'x_picpay_token';
    private PicPay $picpay;

    /**
     * @throws Exception
     */
    function setUp(): void
    {
        /**
         * Brazilian CPF can be only numbers or with default mask
         */
        $this->picpay = new PicPay(self::PICPAY_TOKEN);
        $referenceId = 'MY-ID-' . random_int(1000, 3000);
        $this->picpay
            ->setCustomer([
                'first_name' => 'Din',
                'last_name' => 'Djarin',
                'document' => '963.237.510-62'
            ])
            ->setReferenceId($referenceId)
            ->setValue(random_int(50, 199))
            ->setCallbackUrl("https://my-website-example.com/notification/$referenceId");
    }

    function testToken(): void
    {
        $token = $this->picpay->getPicpayToken();
        if ($token) print DisplayColor::success($token, true);
        $this->assertNotNull($token);
    }

    /**
     * @throws CustomerException
     */
    function testBuyer(): void
    {
        $buyer = $this->picpay->getBuyer();
        $this->assertIsArray($buyer);
    }

    /**
     * @throws CustomerException
     */
    function testPayCharge(): void
    {
        $charge = $this->picpay->getCharge();
        $this->assertIsArray($charge);
    }

    /**
     * @throws CustomerException
     */
    function testChargeToString(): void
    {
        $charge = $this->picpay->getChargeToString();
        if ($charge) print DisplayColor::success($charge, true);
        $this->assertIsString($charge);
    }

    /**
     * @throws GuzzleException|PaymentException|CustomerException
     */
    function testPay(): void
    {
        $response = $this->picpay
            ->setSoftDescriptor('Item Description')->pay();
        if ($response) {
            $this->picpay->order($response['referenceId']);
        }
        $this->assertIsArray($response);
        $this->testStatusInformation();
        $this->testStatusCancellation();
    }

    /**
     * @throws GuzzleException
     * @throws PaymentException
     */
    private function testStatusInformation(): void
    {
        $order = $this->picpay->order()->status();
        $this->assertEquals('created', $order['status']);
    }

    /**
     * @throws GuzzleException
     * @throws PaymentException
     */
    private function testStatusCancellation(): void
    {
        $order = $this->picpay->order()->cancel();
        $this->assertEquals('cancelled', $order['status']);
    }
}