<?php
set_include_path(
    __DIR__ . '/src' . PATH_SEPARATOR
    . __DIR__ . '/vendor/doctrine2/lib' . PATH_SEPARATOR
    . __DIR__ . '/vendor/doctrine2/lib/vendor/doctrine-common/lib' . PATH_SEPARATOR
    . __DIR__ . '/vendor/doctrine2/lib/vendor/doctrine-dbal/lib' . PATH_SEPARATOR
    . __DIR__ . '/vendor/doctrine2/lib/vendor/Symfony' . PATH_SEPARATOR
    . get_include_path()
);

spl_autoload_register(function($className) {
    if (!preg_match('/^(Doctrine|Procrastinator)/', $className)) {
        return;
    }
    require_once strtr($className, '\\', '/') . '.php';
});
