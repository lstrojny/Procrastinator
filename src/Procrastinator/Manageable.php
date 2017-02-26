<?php
namespace Procrastinator;

use Procrastinator\Deferred\Deferred;

interface Manageable
{
    /** @return bool */
    public function has($name);

    /** @return Deferred */
    public function get($name);

    /** @return Deferred[] */
    public function getAll();
}
