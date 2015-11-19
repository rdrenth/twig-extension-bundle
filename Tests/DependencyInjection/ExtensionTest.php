<?php

namespace Rdrenth\Bundle\TwigExtensionBundle\Tests\DependencyInjection;

use Rdrenth\Bundle\TwigExtensionBundle\DependencyInjection\RdrenthTwigExtensionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

/**
 * ExtenionTest
 *
 * @author   Ronald Drenth <ronalddrenth@gmail.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     https://github.com/rdrenth/twig-extension-bundle
 */
class ExtenionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test DI container with default config
     */
    public function testDefaultContainer()
    {
        $config = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/default.yml'));
        $container = $this->getContainer($config);

        $this->assertTrue($container->hasDefinition('rdrenth_twig_extension.stringy'));

        $this->assertEquals(
            $container->getParameterBag()->resolveValue('%rdrenth_twig_extension.stringy.class%'),
            $container->getDefinition('rdrenth_twig_extension.stringy')->getClass()
        );
    }

    /**
     * @param array $config
     * @return ContainerBuilder
     */
    private function getContainer(array $config)
    {
        $container = new ContainerBuilder();
        $loader = new RdrenthTwigExtensionExtension();
        $loader->load($config, $container);
        $container->compile();

        return $container;
    }
}
