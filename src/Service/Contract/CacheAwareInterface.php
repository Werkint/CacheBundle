<?php
namespace Werkint\Bundle\CacheBundle\Service\Contract;

use Doctrine\Common\Cache\CacheProvider;

/**
 * Интерфейс для сервиса, которому нужно работать с кешем
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
interface CacheAwareInterface
{
    /**
     * @param CacheProvider $cache
     * @return $this
     */
    public function setCacheProvider(CacheProvider $cache);
}