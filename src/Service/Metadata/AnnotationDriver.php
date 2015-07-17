<?php
namespace Werkint\Bundle\CacheBundle\Service\Metadata;

use Doctrine\Common\Annotations\Reader;
use Metadata\Driver\DriverInterface;
use Werkint\Bundle\CacheBundle\Service\Annotation\CacheAware;

/**
 * @see    CacheAware
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class AnnotationDriver implements
    DriverInterface
{
    const ANNOTATION_CLASS = CacheAware::class;

    protected $reader;

    /**
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * {@inheritdoc}
     */
    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $classMetadata = new ClassMetadata($class->getName());

        $annotation = $this->reader->getClassAnnotation(
            $class,
            static::ANNOTATION_CLASS
        );

        if ($annotation instanceof CacheAware) {
            $classMetadata->setNamespace($annotation->getNamespace());
        }

        return $classMetadata;
    }
} 