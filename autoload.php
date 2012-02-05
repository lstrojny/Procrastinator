<?php
set_include_path(__DIR__ . '/src' . PATH_SEPARATOR . get_include_path());

spl_autoload_register(function($className) {
    require_once strtr($className, '\\', '/') . '.php';
});