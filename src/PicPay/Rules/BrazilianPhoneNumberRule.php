<?php

namespace EwertonDaniel\PicPay\Rules;

use EwertonDaniel\PicPay\Exceptions\PhoneNumberValidationException;

class BrazilianPhoneNumberRule
{
    const CPF_CLEAR_REGEX = "/[^0-9]/is";
    const VALIDATION_PATTERN_REGEX = "/(?:(?<=^)|(?<=\D))((00|\+)?55(\s|\.|-)*)?((\()?0?\d{2}(?(5)\)|)(\s|\.|-)*)?(9(\s|\.|-)*)?\d{4}(\s|\.|-)*\d{4}(?=\D|$)/m";
    private int $length;

    public function __construct(private string $phone_number)
    {
        $this->__init__();
    }

    /**
     * @throws PhoneNumberValidationException
     */
    private function __init__(): void
    {
        $this->__clear();
        $this->__checkLength();
        $this->__checkIsValidPhoneNumber();
    }

    /**
     * @return void
     * Clears the value leaving only numbers
     */

    private function __clear(): void
    {
        $this->phone_number = preg_replace(self::CPF_CLEAR_REGEX, '', $this->phone_number);
    }

    /**
     * @throws PhoneNumberValidationException
     */
    private function __checkLength(): void
    {
        $this->length = strlen($this->phone_number);
        if ($this->length !== 11 && $this->length !== 10) {
            $this->throwsPhoneNumberException("Entered value doesn't correspond to a valid Phone Number. ($this->length characters total: $this->phone_number).");
        }
    }

    /**
     * @throws PhoneNumberValidationException
     */
    private function __checkIsValidPhoneNumber(): void
    {
        if (!preg_match_all(self::VALIDATION_PATTERN_REGEX, $this->phone_number)) {
            $this->throwsPhoneNumberException("Entered value doesn't correspond to a valid Phone Number. ($this->phone_number).");
        }
    }

    /**
     * @throws PhoneNumberValidationException
     */
    private function throwsPhoneNumberException($message): void
    {
        throw new PhoneNumberValidationException($message, 400);
    }

    private function Mask(string $mask): string
    {
        $str = str_replace(" ", "", $this->phone_number);
        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }
        return $mask;
    }

    public function getPhoneNumberMasked(): string
    {
        $mask = $this->length === 10 ? "## ####-####" : "## #####-####";
        return "+55 " . $this->mask($mask);
    }

    public function getPhoneNumberClean(): string
    {
        return $this->phone_number;
    }
}