<?php
namespace Werkint\Bundle\CacheBundle\Tests\Currency;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Werkint\Bundle\CacheBundle\WerkintCacheBundle;

class WerkintCacheExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testPasses()
    {
        $containerBuilderMock = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $class = 'Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface';
        $containerBuilderMock->expects($this->exactly(1))
            ->method('addCompilerPass')
            ->with($this->isInstanceOf($class))
            ->will($this->returnValue(true));
        $obj = new WerkintCacheBundle();
        $obj->build($containerBuilderMock);
    }

}
