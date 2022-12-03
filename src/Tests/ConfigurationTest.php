<?php

namespace EwertonDaniel\PicPay\Tests;

use EwertonDaniel\PicPay\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    protected Configuration $configuration;

    function setUp(): void
    {
        $this->configuration = new Configuration();
    }

    function testIfSdkVersionInitiated(): void
    {
        $attribute = $this->configuration->getSdkVersion();
        if ($attribute) {
            print DisplayColor::success($attribute, true);
        }
        $this->assertNotNull($attribute);
    }

    function testIfUrlInitiated(): void
    {
        $attribute = $this->configuration->getUrl();
        if ($attribute) {
            print DisplayColor::success($attribute);
        }
        $this->assertNotNull($attribute);
    }

    function testIfEndpointsInitiated(): void
    {
        $attribute = $this->configuration->getEndpoints();
        if ($attribute) {
            print DisplayColor::success('success', true);
        }
        $this->assertIsArray($attribute);
    }

    function testIfTestEndpointInitiated(): void
    {
        $attribute = $this->configuration->getEndpoint('test');
        if ($attribute) {
            print DisplayColor::success('success', true);
        }
        $this->assertIsArray($attribute);
    }
}