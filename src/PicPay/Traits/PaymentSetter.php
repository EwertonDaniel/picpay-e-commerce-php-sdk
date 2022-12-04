<?php

namespace EwertonDaniel\PicPay\Traits;

use Echosistema\SHR\Http;
use EwertonDaniel\PicPay\Customer;
use EwertonDaniel\PicPay\Exceptions\CpfValidationException;
use EwertonDaniel\PicPay\Exceptions\EmailValidationException;

trait PaymentSetter
{
    public Customer $customer;
    private null|string $url;
    private null|array $endpoint;
    private string $referenceId;
    private null|string $callbackUrl = null;
    private null|string $returnUrl = null;
    private float $value;
    private null|string $expiresAt = null;
    private null|string $channel = null;
    private string $purchaseMode = 'online';
    private null|string $softDescriptor = null;
    private bool $autoCapture = true;

    private function __setEndpoint(): void
    {
        $this->endpoint = $this->configuration->getEndpoint('payments');
    }

    private function __setUrl(): void
    {
        $url = $this->configuration->getUrl();
        if (!$url || !isset($this->endpoint['uri'])) return;
        $this->url = $url . $this->endpoint['uri'];
    }

    /**
     * @throws CpfValidationException
     * @throws EmailValidationException
     */
    public function setCustomer(Customer|array $customer): static
    {
        if (!is_array($customer)) {
            $this->customer = $customer;
            return $this;
        }
        $this->customer = new Customer();
        if (isset($customer['first_name'])) {
            $this->customer->setFirstName($customer['first_name']);
        }
        if (isset($customer['last_name'])) {
            $this->customer->setLastName($customer['last_name']);
        }
        if (isset($customer['document'])) {
            $this->customer->setDocument($customer['document']);
        }
        if (isset($customer['email'])) {
            $this->customer->setEmail($customer['email']);
        }
        if (isset($customer['phone_number'])) {
            $this->customer->setPhoneNumber($customer['phone_number']);
        }
        return $this;
    }

    public function setDebug(bool $debug): static
    {
        $this->client = new Http($debug);
        return $this;
    }

    /**
     * @param string|null $reference_id
     * @return $this
     */
    public function setReferenceId(string|null $reference_id = null): static
    {
        $this->referenceId = $reference_id ?? preg_replace('/[^0-9]/is', '', microtime());
        return $this;
    }

    /**
     * @param string $callback_url
     * @return $this
     */
    public function setCallbackUrl(string $callback_url): static
    {
        $this->callbackUrl = $callback_url;

        return $this;
    }

    /**
     * @param string $returnUrl
     * @return $this
     */
    public function setReturnUrl(string $returnUrl): static
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /**
     * Set the value of value
     *
     * @param float $value
     *
     * @return  static
     */
    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param string $expires_at
     * @return $this
     */
    public function setExpirationDate(string $expires_at): static
    {
        $expires_at = "$expires_at 00:00:01";
        $this->expiresAt = date('Y-m-d\TH:i:sO', strtotime($expires_at));
        return $this;
    }

    /**
     * @param string $channel
     * @return $this
     */
    public function setChannel(string $channel): static
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @param string $purchase_mode
     * @return $this
     */
    public function setPurchaseMode(string $purchase_mode): static
    {
        if (!in_array($purchase_mode, ['online', 'in-store'])) {
            return $this;
        }
        $this->purchaseMode = $purchase_mode;
        return $this;
    }

    /**
     * @param $soft_descriptor
     * @return $this
     */
    public function setSoftDescriptor($soft_descriptor): static
    {
        $this->softDescriptor = $soft_descriptor;

        return $this;
    }

    /**
     * @param bool $auto_capture
     * @return $this
     */
    public function setAutoCapture(bool $auto_capture): static
    {
        $this->autoCapture = $auto_capture;

        return $this;
    }
}