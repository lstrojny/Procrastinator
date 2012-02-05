<?php
namespace Procrastinator\Deferred;

interface Deferred
{
    public function getName();

    public function getCallback();
}