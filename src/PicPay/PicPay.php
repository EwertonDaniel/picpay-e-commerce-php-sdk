<?php

namespace EwertonDaniel\PicPay;

use EwertonDaniel\PicPay\Exceptions\PaymentException;
use EwertonDaniel\PicPay\Traits\AutoInit;
use EwertonDaniel\PicPay\Traits\PaymentGetter;
use EwertonDaniel\PicPay\Traits\PaymentSetter;
use EwertonDaniel\PicPay\Traits\PicPayAuthorization;
use EwertonDaniel\PicPay\Traits\PicPayConfiguration;
use GuzzleHttp\Exception\GuzzleException;


class PicPay
{
    use AutoInit,
        PicPayConfiguration,
        PicPayAuthorization,
        PaymentSetter,
        PaymentGetter;

    private array $charge;
    private array $notification = [
        'disablePush' => false,
        'disableEmail' => false
    ];

    public function __construct(string $picpay_token)
    {
        $this->__init__($picpay_token);
    }

    /**
     * @param bool $disable
     * @return $this
     */
    public function disableAppPushNotification(bool $disable): static
    {
        $this->notification['disablePush'] = $disable;
        return $this;
    }

    /**
     * @param bool $disable
     * @return $this
     */
    public function disableEmailNotification(bool $disable): static
    {
        $this->notification['disableEmail'] = $disable;
        return $this;
    }

    public function order(string|null $reference_id = null): Order
    {
        return !isset($reference_id) ? $this->order : $this->order->setReferenceId($reference_id);
    }

    /**
     * @throws PaymentException
     */
    private function validate(): void
    {
        if (!isset($this->value)) {
            throw new PaymentException("Item value is required");
        }
        if (!isset($this->url)) {
            throw new PaymentException("Endpoint Url is required");
        }
        if (!isset($this->callbackUrl)) {
            throw new PaymentException("Callback Url is required");
        }
        if (!isset($this->charge['buyer'])) {
            throw new PaymentException("Customer/Buyer is required");
        }
    }


    /**
     * @throws GuzzleException
     * @throws PaymentException|Exceptions\CustomerException
     * @link https://studio.picpay.com/produtos/e-commerce/checkout/guides/accepting-payments
     */
    public function pay(): array
    {
        $this->charge = $this->getCharge();
        $this->validate();
        $this->client->withJson($this->charge);
        $this->client->addHeader('x-picpay-token', $this->authorization->getPicPayToken());
        $this->client->addHeader('User-Agent', $this->configuration->getSdkVersion());
        $response = $this->client->post($this->url);
        $response['body']['success'] = $response['successfully'] ?? false;
        return $response['body'];
    }
}