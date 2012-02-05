<?php
namespace Procrastinator;

interface Managable
{
    public function has($name);
    public function get($name);
    public function getAll();
}