<?php
namespace Werkint\Bundle\CacheBundle\Service\Metadata;

use Metadata\MergeableClassMetadata;
use Metadata\MergeableInterface;
use Werkint\Bundle\CacheBundle\Service\Annotation\CacheAware;

/**
 * @see CacheAware
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class ClassMetadata extends MergeableClassMetadata
{
    /**
     * @var null|string
     */
    protected $namespace = null;

    /**
     * @inheritdoc
     */
    public function merge(MergeableInterface $object)
    {
        parent::merge($object);

        if($object instanceof ClassMetadata){
            $this->setNamespace($object->getNamespace());
        }
    }

    // -- Accessors ---------------------------------------

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param null|string $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }
} 