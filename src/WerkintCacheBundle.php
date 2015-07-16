<?php
namespace Werkint\Bundle\CacheBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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
        $container->addCompilerPass(new CacheProviderPass);
    }
}
