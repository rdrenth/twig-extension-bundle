<?php

namespace Rdrenth\Bundle\TwigExtensionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * RdrenthTwigExtensionExtension
 *
 * @author   Ronald Drenth <ronalddrenth@gmail.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     https://github.com/rdrenth/twig-extension-bundle
 */
class RdrenthTwigExtensionExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($config, $container);
        $config = $this->processConfiguration($configuration, $config);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if (isset($config['stringy'])) {
            $this->registerStringyConfiguration($config['stringy'], $container, $loader);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'rdrenth_twig_extension';
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     * @param XmlFileLoader $loader
     */
    private function registerStringyConfiguration(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        if (!$this->isConfigEnabled($container, $config)) {
            return;
        }

        $filters = array();
        foreach ($config['filters'] as $filterConfig) {
            if (!$this->isConfigEnabled($container, $filterConfig)) {
                continue;
            }

            $filters[$filterConfig['filter']] = $filterConfig['method'];
        }

        foreach ($config['extra_filters'] as $filterConfig) {
            $filters[$filterConfig['filter']] = $filterConfig['method'];
        }

        $definition = $container->findDefinition('rdrenth_twig_extension.stringy');
        $definition->addTag('twig.extension')
            ->addArgument($filters)
            ->addArgument($config['encoding']);
    }
}
