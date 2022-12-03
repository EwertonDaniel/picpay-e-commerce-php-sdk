<?php

namespace EwertonDaniel\PicPay;

use GuzzleHttp\Utils;

class Authorization
{
    protected string $picpay_token;
    protected string $seller_token;

    public function __construct(array $credential = array())
    {
        $this->__init__($credential);
    }

    private function __init__(array $credential = array()): void
    {
        if (isset($credential['picpay_token'])) {
            $this->setPicPayToken($credential['picpay_token']);
        }
        if (isset($credential['seller_token'])) {
            $this->setSellerToken($credential['seller_token']);
        }
    }

    public function setPicPayToken(string $picpay_token): void
    {
        $this->picpay_token = $picpay_token;
    }

    public function getPicPayToken(): null|string
    {
        return $this->picpay_token ?? null;
    }

    private function setSellerToken(string $seller_token): void
    {
        $this->seller_token = $seller_token;
    }

    public function getSellerToken(): null|string
    {
        return $this->seller_token ?? null;
    }

    public function getCredentials(): array
    {
        return [
            'x-picpay-token'=>$this->getPicPayToken(),
            'x-seller-token'=>$this->getSellerToken()
        ];
    }

    public function __toString(): string
    {
        return Utils::jsonEncode($this->getCredentials());
    }
}