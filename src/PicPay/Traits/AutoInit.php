<?php

namespace EwertonDaniel\PicPay\Traits;

use Echosistema\SHR\Http;
use EwertonDaniel\PicPay\Order;

trait AutoInit
{
    private Http $client;
    private Order $order;

    private function __init__(string $picpay_token): void
    {
        $this->__setConfiguration();
        $this->__setAuthorization($picpay_token);
        $this->__setEndpoint();
        $this->__setUrl();
        $this->client = new Http();
        $this->order = new Order($picpay_token);
    }
}