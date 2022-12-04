<?php

use EwertonDaniel\PicPay\Customer;
use EwertonDaniel\PicPay\Exceptions\CpfValidationException;
use EwertonDaniel\PicPay\Exceptions\CustomerException;
use EwertonDaniel\PicPay\Exceptions\EmailValidationException;
use EwertonDaniel\PicPay\Traits\DisplayColor;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    use DisplayColor;

    protected Customer $customer;

    /**
     * @throws EmailValidationException
     */
    function setUp(): void
    {
        $this->customer = new Customer();
        $this->customer->setFirstName('Anakin')
            ->setLastName('Skywalker')
            ->setEmail('anakin@orderjedi.com') // Optional
            ->setPhoneNumber('11987654321'); // Optional
    }

    /**
     * @throws CustomerException
     * @throws CpfValidationException
     */
    function testBuyer(): void
    {
        $this->customer->setDocument('96323751062');
        $attribute = $this->customer->getBuyer();
        if (!empty($attribute)) {
            print $this->success('BUYER OK', true);
        }
        $this->assertIsArray($attribute);
    }

    /**
     * @throws CpfValidationException
     */
    function testValidCpf(): void
    {
        $this->customer->setDocument('96323751062');
        $document = $this->customer->getDocument();
        if ($document) {
            print $this->success('DOCUMENT OK');
            print $this->information($document, true);
        }
        $this->assertEquals('963.237.510-62', $document);
    }

    /**
     * @throws CpfValidationException
     * @throws CustomerException
     */
    function testValidPhoneNumber(): void
    {
        $this->customer->setDocument('96323751062');
        $this->customer->setPhoneNumber('11912345678');
        $attributes = $this->customer->getBuyer();
        $this->assertEquals('+55 11 91234-5678', $attributes['phone']);
    }

    /**
     * @throws CpfValidationException
     */
    function testValidEmail(): void
    {
        $this->customer->setDocument('96323751062');
        $this->customer->setPhoneNumber('11912345678');
        $this->assertEquals('+55 11 91234-5678', $this->customer->getPhoneNumber());
    }
}