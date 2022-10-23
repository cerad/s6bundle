<?php

namespace Cerad\MyBundle;

use Cerad\MyBundle\DependencyInjection\TwigPass;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CeradMyBundle extends AbstractBundle implements CompilerPassInterface
{
  public function build(ContainerBuilder $container): void
  {
      //parent::build($container);
      //$container->addCompilerPass(new TwigPass());
      $container->addCompilerPass($this);
  }
  public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
  {
    //$container->import('../config/services.php');

      $container->parameters()
        ->set('my.theme', $config['theme']);
  }
  public function configure(DefinitionConfigurator $definition): void
  {
      $definition->rootNode()
          ->children()
              ->scalarNode('theme')->defaultValue('theme_default')->end()
          ->end()
      ;
  }
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
