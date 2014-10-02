# Procrastinator for PHP: do stuff later [![Build Status](https://secure.travis-ci.org/lstrojny/Procrastinator.svg)](http://travis-ci.org/lstrojny/Procrastinator) [![Dependency Status](https://www.versioneye.com/user/projects/523ed7e0632bac1b0b00b265/badge.png)](https://www.versioneye.com/user/projects/523ed7e0632bac1b0b00b265) [![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/lstrojny/procrastinator.svg)](http://isitmaintained.com/project/lstrojny/procrastinator "Average time to resolve an issue") [![Percentage of issues still open](http://isitmaintained.com/badge/open/lstrojny/procrastinator.svg)](http://isitmaintained.com/project/lstrojny/procrastinator "Percentage of issues still open")

A few classes to help you executing complicated tasks (like sending mails) later.


### Example using fastcgi_finish_request() to finish request before executing tasks
```php
<?php
$procrastinator = new \Procrastinator\DeferralManager(
    new \Procrastinator\Scheduler\OnRegisterShutdownScheduler(),
    new \Procrastinator\Executor\Decorator\PhpFpmExecutorDecorator(
        new \Procrastinator\Executor\SingleThreadExecutor()
    )
);

// The rough way
$procrastinator->register(
    new \Procrastinator\Deferred\CallbackDeferred(
        'some name',
        function() {sleep(10);}
    )
);

// Or use the more convenient builder interface
$procrastinator->register(
    $procrastinator
        ->newDeferred()
        ->name('some other name')
        ->call(function() {sleep(10);}
        ->build()
);

$procrastinator->schedule();
```
