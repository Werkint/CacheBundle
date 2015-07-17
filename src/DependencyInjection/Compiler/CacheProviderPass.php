<?php
namespace Werkint\Bundle\CacheBundle\DependencyInjection\Compiler;

use Metadata\MetadataFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Werkint\Bundle\CacheBundle\Service\Contract\CacheAwareInterface;
use Werkint\Bundle\CacheBundle\Service\Metadata\ClassMetadata;

/**
 * Добавляет в классы с CacheAwareInterface кеш-провайдеры
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class CacheProviderPass implements
    CompilerPassInterface
{
    const INTERFACE_CLASS = CacheAwareInterface::class;
    const METADATA_FACTORY = 'werkint_cache.metadata.metadatafactory';
    const ROOT_NAMESPACE = 'root';
    // Basic cache services
    const PROVIDER_SERVICE = 'werkint_cache.cacheprovider';
    // Префикс для сервисов кеша
    const PROVIDER_PREFIX = self::PROVIDER_SERVICE . '.';

    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $this->container = $container;

        foreach ($container->getDefinitions() as $definition) {
            $this->processDefinition($definition);
            $this->processInlineDefinitions($definition->getArguments());
            $this->processInlineDefinitions($definition->getMethodCalls());
            $this->processInlineDefinitions($definition->getProperties());
        }
    }

    /**
     * Фабрика метаданных для обрабатываемых классов
     *
     * @return MetadataFactory
     */
    protected function getMetadataFactory()
    {
        return $this->container->get(static::METADATA_FACTORY);
    }

    /**
     * @param Definition $definition
     */
    protected function processDefinition(
        Definition $definition
    ) {
        if ($definition->isSynthetic()) {
            return;
        }

        if ($definition->getFactoryService() || $definition->getFactoryClass()) {
            return;
        }

        if ($file = $definition->getFile()) {
            require_once $file;
        }

        if (!class_exists($definition->getClass())) {
            return;
        }

        $class = new \ReflectionClass($definition->getClass());

        if (!$class->implementsInterface(static::INTERFACE_CLASS)) {
            return;
        }

        $metadata = $this->getMetadataFactory()->getMetadataForClass(
            $definition->getClass()
        );

        if (!$metadata instanceof ClassMetadata) {
            return;
        }

        $namespace = $metadata->getNamespace() ?: static::ROOT_NAMESPACE;
        $serviceName = static::PROVIDER_PREFIX . substr(sha1($namespace), 0, 10);

        if (!$this->container->hasDefinition($serviceName)) {
            $cacher = new Definition('Werkint\Bundle\CacheBundle\Service\CacheProvider',[
                $this->container->getParameter('kernel.cache_dir').'/werkint_cache'
            ]);
            $cacher->setPublic(true);
            $cacher->addMethodCall('setNamespace', [$namespace]);
            $this->container->setDefinition($serviceName, $cacher);
        }

        $definition->addMethodCall('setCacheProvider', [new Reference($serviceName)]);
    }

    private function processInlineDefinitions(array $a)
    {
        foreach ($a as $k => $v) {
            if ($v instanceof Definition) {
                $this->processDefinition($v);
            } elseif (is_array($v)) {
                $this->processInlineDefinitions($v);
            }
        }
    }
}
