<?php
namespace Procrastinator\Deferred;

interface Deferred
{
    /** @return string */
    public function getName();

    /** @return callable */
    public function getCallback();
}
