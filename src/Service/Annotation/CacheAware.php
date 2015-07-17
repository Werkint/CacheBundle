<?php
namespace Werkint\Bundle\CacheBundle\Service\Annotation;

use Doctrine\ORM\Mapping\Annotation;

/**
 * Отмечает класс, в котором должен быть кеш-провайдер
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 *
 * @Annotation
 * @Target("CLASS")
 */
class CacheAware
{
    /**
     * @var string|null
     */
    protected $namespace;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->namespace = isset($data['namespace']) ? $data['namespace'] : null;
    }

    // -- Accessors ---------------------------------------

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
} 