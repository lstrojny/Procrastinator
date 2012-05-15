<?php
namespace Procrastinator\Executor\Decorator;

use PHPUnit_Framework_TestCase as TestCase;
use Procrastinator\Deferred\CallbackDeferred;

abstract class AbstractPhpFpmExecutorDecoratorTest extends TestCase
{
    protected $executor;
    protected $decorator;
    protected $executable;
    protected $deferred;
}

function fastcgi_finish_request()
{
    $GLOBALS['fastcgi_finish_request'] = true;
}
