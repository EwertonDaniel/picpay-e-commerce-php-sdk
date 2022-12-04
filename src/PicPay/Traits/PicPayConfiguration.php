<?php

namespace EwertonDaniel\PicPay\Traits;

use EwertonDaniel\PicPay\Configuration;

trait PicPayConfiguration
{
    private Configuration $configuration;

    protected function __setConfiguration(): void
    {
        $this->configuration = new Configuration();
    }
}