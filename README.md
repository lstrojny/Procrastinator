# Procrastinator for PHP: do stuff later

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
        function() {
            sleep(10);
        }
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