<?php

spl_autoload_register(function ($class) {

    if (substr(strtolower($class), 0, 6) !== 'picpay\\') {
        return;
    }
    $path = __DIR__ . '/src/PicPay/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require($path);
    }
});