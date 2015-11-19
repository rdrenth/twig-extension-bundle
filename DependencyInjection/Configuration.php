<?php

namespace Rdrenth\Bundle\TwigExtensionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * RdrenthTwigExtensionBundle configuration structure
 *
 * @author   Ronald Drenth <ronalddrenth@gmail.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     https://github.com/rdrenth/twig-extension-bundle
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rdrenth_twig_extension');

        $this->addStringySection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function addStringySection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('stringy')
                    ->canBeDisabled()
                    ->fixXmlConfig('extra_filter')
                    ->children()
                        ->scalarNode('encoding')->defaultNull()->end()
                        ->arrayNode('filters')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->append($this->addStringyMethodNode('ascii', 'toAscii'))
                                ->append($this->addStringyMethodNode('camelize'))
                                ->append($this->addStringyMethodNode('dasherize'))
                                ->append($this->addStringyMethodNode('delimit'))
                                ->append($this->addStringyMethodNode('humanize'))
                                ->append($this->addStringyMethodNode('slugify'))
                                ->append($this->addStringyMethodNode('titleize'))
                                ->append($this->addStringyMethodNode('underscored'))
                            ->end()
                        ->end()
                        ->arrayNode('extra_filters')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('filter')->end()
                                    ->scalarNode('method')
                                        ->validate()
                                        ->ifTrue(function($value) { return !method_exists('Stringy\Stringy', $value); })
                                            ->thenInvalid('Method %s does not on the class Stringy\Stringy.')
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param string $filterName
     * @param string|null $methodName
     * @return NodeDefinition
     */
    private function addStringyMethodNode($filterName, $methodName = null)
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($filterName);
        $rootNode
            ->canBeEnabled()
            ->children()
                ->scalarNode('filter')
                    ->defaultValue($filterName)
                ->end()
                ->scalarNode('method')
                    ->defaultValue($methodName ?: $filterName)
                    ->validate()
                    ->ifTrue(function($value) { return !method_exists('Stringy\Stringy', $value); })
                        ->thenInvalid('Method %s does not on the class Stringy\Stringy.')
                    ->end()
                ->end()
            ->end();

        return $rootNode;
    }
}
