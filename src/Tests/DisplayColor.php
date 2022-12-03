<?php

namespace EwertonDaniel\PicPay\Tests;

class DisplayColor
{
    const SUCCESS = "\e[102;97m";

    const ATTENTION = "\e[103;97m";

    const ERROR = "\e[101;97m";

    const CLEAR = "\e[0m";

    public static function error($text, $new_line = false): string
    {
        $text = '**** ERROR: ' . self::ERROR . ' ' . $text . ' ' . self::CLEAR;
        $text .= $new_line ? "\n" : "";
        return $text;

    }

    public static function attention($text, $new_line = false): string
    {
        $text = "*** ATTENTION: " . self::ATTENTION . " " . $text . " " . self::CLEAR;
        $text .= $new_line ? "\n" : "";
        return $text;

    }

    public static function success($text, $new_line = false): string
    {
        $text = "* SUCCESS: " . self::SUCCESS . " " . $text . " " . self::CLEAR;
        $text .= $new_line ? "\n\n" : "";
        return $text;

    }
}