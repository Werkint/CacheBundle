<?php
namespace Werkint\Bundle\CacheBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class WerkintCacheExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(
            $this->getConfiguration($configs, $container),
            $configs
        );
        // TODO: restructure
        $container->setParameter(
            $this->getAlias(), $config
        );
        $container->setParameter(
            $this->getAlias() . '_connection',
            $config['connection']
        );
        $container->setParameter(
            $this->getAlias() . '_project',
            $config['project']
        );
        $prefix = $config['project'] . '_';
        $prefix .= $container->getParameter('kernel.environment');
        $container->setParameter(
            $this->getAlias() . '_prefix', $prefix
        );
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        $config = new Configuration($this->getAlias());
        $r = new \ReflectionClass($config);
        $container->addResource(new FileResource($r->getFileName()));
        return $config;
    }
}
