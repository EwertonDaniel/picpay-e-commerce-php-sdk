<?php

namespace EwertonDaniel\PicPay\Traits;

use EwertonDaniel\PicPay\Authorization;

trait PicPayAuthorization
{
    private Authorization $authorization;

    public function __setAuthorization(string $pic_pay_token): static
    {
        $this->authorization = new Authorization(['picpay_token' => $pic_pay_token]);
        return $this;
    }
}