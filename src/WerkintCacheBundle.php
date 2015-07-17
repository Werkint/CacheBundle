<?php
namespace Werkint\Bundle\CacheBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Werkint\Bundle\CacheBundle\DependencyInjection\Compiler\CacheProviderPass;

/**
 * WerkintCacheBundle.
 */
class WerkintCacheBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // Cache
        $container->addCompilerPass(new CacheProviderPass(), PassConfig::TYPE_AFTER_REMOVING);
    }
}
