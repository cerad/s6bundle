<?php

namespace Cerad\MyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('twig')) {
            return;
        }
        $theme = $container->getParameter('my.theme');
        $def = $container->getDefinition('twig');
        $def->addMethodCall('addGlobal', ['theme', $theme]);
    }
}