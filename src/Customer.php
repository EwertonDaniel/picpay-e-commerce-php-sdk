<?php

namespace EwertonDaniel\PicPay;

use EwertonDaniel\PicPay\Exceptions\CpfValidationException;
use EwertonDaniel\PicPay\Exceptions\CustomerException;
use EwertonDaniel\PicPay\Exceptions\EmailValidationException;
use EwertonDaniel\PicPay\Rules\BrazilianPhoneNumberRule;
use EwertonDaniel\PicPay\Rules\CpfRule;
use EwertonDaniel\PicPay\Rules\EmailRule;


class Customer
{
    protected string $firstName;
    protected string $lastName;
    protected string $document;
    protected string $email;
    protected string $phone;

    public function setFirstName(string $first_name): static
    {
        $this->firstName = $first_name;
        return $this;
    }

    public function setLastName(string $last_name): static
    {
        $this->lastName = $last_name;
        return $this;
    }

    /**
     * @throws CpfValidationException
     */
    public function setDocument(string $document): static
    {
        $this->document = (new CpfRule($document))->getCpfMasked();
        return $this;
    }

    /**
     * @return string|null
     * return customer CPF Document
     */
    public function getDocument(): null|string
    {
        return $this->document ?? null;
    }

    /**
     * @throws EmailValidationException
     */
    public function setEmail(string $email, bool $validate = true): static
    {
        $this->email = $validate ? (new EmailRule($email))->getEmail() : $email;
        return $this;
    }

    public function setPhoneNumber(string $phone_number): static
    {
        $this->phone = (new BrazilianPhoneNumberRule($phone_number))->getPhoneNumberMasked();
        return $this;
    }

    public function getPhoneNumber(): null|string
    {
        return $this->phone ?? null;
    }

    /**
     * @throws CustomerException
     */
    public function getBuyer(): array
    {
        $this->validate();
        return get_object_vars($this);
    }

    /**
     * @throws CustomerException
     */
    public function validate(): static
    {
        if (!isset($this->firstName)) {
            throw new CustomerException("Customer First Name can't be null", 400);
        }
        if (!isset($this->lastName)) {
            throw new CustomerException("Customer Last Name can't be null", 400);
        }
        if (!isset($this->document)) {
            throw new CustomerException("Customer Document can't be null", 400);
        }
        return $this;
    }
}