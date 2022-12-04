<?php

namespace EwertonDaniel\PicPay;

use Echosistema\SHR\Http;
use EwertonDaniel\PicPay\Exceptions\PaymentException;
use EwertonDaniel\PicPay\Traits\PicPayAuthorization;
use EwertonDaniel\PicPay\Traits\PicPayConfiguration;
use GuzzleHttp\Exception\GuzzleException;

class Order
{
    use PicPayConfiguration, PicPayAuthorization;

    /**
     * @var array|null
     */
    private null|array $endpoint;
    /**
     * @var string
     */
    private string $url;

    /**
     * @param string $picpay_token
     * @param null|string $reference_id
     */
    public function __construct(private readonly string $picpay_token, private null|string $reference_id = null)
    {
        $this->__init__($picpay_token);
    }

    private Http $client;

    private function __init__(string $picpay_token): void
    {
        $this->__setConfiguration();
        $this->__setAuthorization($picpay_token);
        $this->client = new Http();
        $this->__setHeaders();
    }

    private function __setHeaders(): void
    {
        $this->client->addHeader('x-picpay-token', $this->authorization->getPicPayToken());
        $this->client->addHeader('User-Agent', $this->configuration->getSdkVersion());
    }

    public function setReferenceId($reference_id): static
    {
        $this->reference_id = $reference_id;
        return $this;
    }

    private function setEndpoint($endpoint): void
    {
        $this->endpoint = $this->configuration->getEndpoint($endpoint);
        $this->__setUrl();
    }

    /**
     * @return void
     */
    private function __setUrl(): void
    {
        $url = $this->configuration->getUrl();
        if (!$url || !isset($this->endpoint['uri'])) return;
        $uri = str_replace('{referenceId}', $this->reference_id, $this->endpoint['uri']);
        $this->url = $url . $uri;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @throws GuzzleException
     * @throws PaymentException
     * @link https://studio.picpay.com/produtos/e-commerce/checkout/guides/cancel-order
     */
    public function cancel(): array
    {
        $this->setEndpoint('cancel');
        $this->validate();
        $response = $this->client->post($this->getUrl());
        $response['body']['status'] = isset($response['body']['cancellationId']) ? 'cancelled' : 'undefined';
        $response['body']['success'] = $response['successfully'] ?? false;
        return $response['body'];
    }

    /**
     * @throws GuzzleException
     * @throws PaymentException
     * @link https://studio.picpay.com/produtos/e-commerce/checkout/guides/order-status
     */
    public function status(): array
    {
        $this->setEndpoint('status');
        $this->validate();
        $response = $this->client->get($this->url);
        $response['body']['success'] = $response['successfully'] ?? false;
        return $response['body'];
    }

    /**
     * @throws PaymentException
     */
    private function validate(): void
    {
        if (!isset($this->reference_id)) {
            throw new PaymentException("Reference Id is required");
        }
        if (!isset($this->url)) {
            throw new PaymentException("Endpoint Url is required");
        }
    }
}