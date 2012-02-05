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

$procrastinator->register(
    new \Procrastinator\Deferred\CallbackDeferred(
        'some name',
        function() {
            sleep(10);
        }
    )
);

$procrastinator->schedule();
```