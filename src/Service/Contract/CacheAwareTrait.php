<?php
namespace Werkint\Bundle\CacheBundle\Service\Contract;

use Doctrine\Common\Cache\CacheProvider;

/**
 * @see CacheAwareInterface
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
trait CacheAwareTrait
{
    /**
     * @var CacheProvider|null
     */
    protected $cacheProvider;

    /**
     * @param CacheProvider $cacheProvider
     * @return $this
     */
    public function setCacheProvider(CacheProvider$cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
        return $this;
    }
}