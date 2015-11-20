<?php

namespace Rdrenth\Bundle\TwigExtensionBundle\Tests\DependencyInjection;

use Rdrenth\Bundle\TwigExtensionBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

/**
 * ConfigurationTest
 *
 * @author   Ronald Drenth <ronalddrenth@gmail.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     https://github.com/rdrenth/twig-extension-bundle
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function provideStringyFilters()
    {
        return array(
            'ascii' => 'toAscii',
            'camelize' => 'camelize',
            'dasherize' => 'dasherize',
            'delimit' => 'delimit',
            'humanize' => 'humanize',
            'slugify' => 'slugify',
            'titleize' => 'titleize',
            'underscored' => 'underscored',
        );
    }

    /**
     * Test to make sure the default configuration is correctly processed
     */
    public function testDefaultConfigurationProcessing()
    {
        $rawConfig = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/default.yml'));
        $config = $this->processConfiguration($rawConfig);

        $this->assertArrayHasKey('stringy', $config);
    }

    /**
     * Test to make sure the stringy section of the configuration is correctly processed
     */
    public function testStringyConfigurationProcessing()
    {
        $rawConfig = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/stringy.yml'));
        $config = $this->processConfiguration($rawConfig);

        $this->assertArrayHasKey('stringy', $config);
        $config = $config['stringy'];

        $this->assertArrayHasKey('enabled', $config);
        $this->assertArrayHasKey('encoding', $config);
        $this->assertArrayHasKey('filters', $config);
        $this->assertArrayHasKey('extra_filters', $config);

        $filters = $config['filters'];
        foreach ($this->provideStringyFilters() as $filterName => $methodName) {
            $this->assertStringyFilter($filters, $filterName, $filterName, $methodName, true);
        }

        $this->assertStringyFilter($config['extra_filters'], 0, 'swap_case', 'swapCase');
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testInvalidStringyMethod()
    {
        $rawConfig = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/stringy-invalid.yml'));
        $this->processConfiguration($rawConfig);
    }

    /**
     * @param array $filters
     * @param mixed $indexName
     * @param string $filterName
     * @param string $methodName
     * @param bool|null $enabled
     */
    private function assertStringyFilter(array $filters, $indexName, $filterName, $methodName, $enabled = null)
    {
        if ($enabled !== null) {
            $this->assertEquals($enabled, $filters[$indexName]['enabled']);
        }

        $this->assertEquals($filterName, $filters[$indexName]['filter']);
        $this->assertEquals($methodName, $filters[$indexName]['method']);
    }

    /**
     * Processes an array of raw configuration and returns a compiled version.
     *
     * @param array $config
     * @return array
     */
    private function processConfiguration(array $config)
    {
        $processor = new Processor();

        return $processor->processConfiguration(new Configuration(), $config);
    }
}
