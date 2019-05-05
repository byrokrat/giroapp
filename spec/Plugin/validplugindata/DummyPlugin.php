<?php

use byrokrat\giroapp\Plugin\PluginInterface;
use byrokrat\giroapp\Plugin\EnvironmentInterface;

return new class implements PluginInterface
{
    public function loadPlugin(EnvironmentInterface $env): void
    {
        $env->readConfig('custom-test-check');
    }
};
