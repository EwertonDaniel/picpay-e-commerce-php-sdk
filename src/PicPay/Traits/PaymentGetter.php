<?php

namespace EwertonDaniel\PicPay\Traits;

use EwertonDaniel\PicPay\Exceptions\CustomerException;
use GuzzleHttp\Utils;

trait PaymentGetter
{
    /**
     * @return string|null
     */
    public function getPicpayToken(): null|string
    {
        return $this->authorization->getPicPayToken();
    }

    /**
     * @return string|null
     */
    public function getReferenceId(): null|string
    {
        return $this->referenceId ?? null;
    }

    /**
     * @throws CustomerException
     */
    public function getBuyer(): array
    {
        return $this->customer->getBuyer();
    }

    /**
     * @return string|null
     */
    public function getCallbackUrl(): null|string
    {
        return $this->callbackUrl ?? null;
    }

    /**
     * @return string|null
     */
    public function getReturnUrl(): null|string
    {
        return $this->returnUrl ?? null;
    }

    /**
     * @return float|null
     */
    public function getValue(): null|float
    {
        return $this->value ?? null;
    }

    /**
     * @return string|null
     */
    public function getExpirationDate(): null|string
    {
        return $this->expiresAt ?? null;
    }

    /**
     * @return string|null
     */
    public function getChannel(): null|string
    {
        return $this->channel ?? null;
    }

    /**
     * @return string|null
     */
    public function getPurchaseMode(): null|string
    {
        return $this->purchaseMode ?? null;
    }

    /**
     * @return string|null
     */
    public function getSoftDescriptor(): null|string
    {
        return $this->softDescriptor ?? null;
    }

    /**
     * @return bool
     */
    public function getAutoCapture(): bool
    {
        return $this->autoCapture;
    }

    /**
     * @return array
     * @throws CustomerException
     */
    public function getCharge(): array
    {
        return [
            'referenceId' => $this->referenceId ?? $this->setReferenceId(),
            'returnUrl' => $this->returnUrl,
            'callbackUrl' => $this->callbackUrl,
            'expiresAt' => $this->expiresAt,
            'channel' => $this->channel,
            'value' => $this->value,
            'purchaseMode' => $this->purchaseMode,
            'buyer' => $this->customer->getBuyer(),
            'softDescriptor' => $this->softDescriptor,
            'notification' => $this->notification,
            'autoCapture' => $this->autoCapture
        ];
    }

    /**
     * @return string
     * @throws CustomerException
     */
    public function getChargeToString(): string
    {
        return Utils::jsonEncode($this->getCharge());
    }
}