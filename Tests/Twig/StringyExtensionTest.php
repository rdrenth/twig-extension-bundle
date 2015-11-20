<?php

namespace Rdrenth\Bundle\TwigExtensionBundle\Tests\Twig;

use Rdrenth\Bundle\TwigExtensionBundle\DependencyInjection\RdrenthTwigExtensionExtension;
use Rdrenth\Bundle\TwigExtensionBundle\Twig\StringyExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

/**
 * StringyExtensionTest
 *
 * @author   Ronald Drenth <ronalddrenth@gmail.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     https://github.com/rdrenth/twig-extension-bundle
 */
class StringyExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @type \Twig_Environment
     */
    private $twig;

    /**
     * @type array
     */
    private $twigTemplates = array(
        'ascii' => "{{ value|ascii(true) }}",
        'camelize' => "{{ value|camelize }}",
        'dasherize' => "{{ value|dasherize }}",
        'delimit' => "{{ value|delimit('::') }}",
        'humanize' => "{{ value|humanize }}",
        'slugify' => "{{ value|slugify('-') }}",
        'titleize' => "{{ value|titleize(['to', 'at']) }}",
        'underscored' => "{{ value|underscored }}",
        'swap_case' => "{{ value|swap_case }}",
    );

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $rawConfig = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/stringy.yml'));
        $container = $this->getContainer($rawConfig);

        /** @type StringyExtension $twigExtension */
        $twigExtension = $container->get('rdrenth_twig_extension.stringy');

        $this->twig = new \Twig_Environment(new \Twig_Loader_Array($this->twigTemplates));
        $this->twig->addExtension($twigExtension);
    }

    public function testAsciiFilter()
    {
        $this->assertSame(
            $this->twig->render('ascii', array('value' => 'fòôbàř')),
            'foobar'
        );
    }

    public function testCamelizeFilter()
    {
        $this->assertSame(
            $this->twig->render('camelize', array('value' => 'Camel-Case')),
            'camelCase'
        );
    }

    public function testDasherizeFilter()
    {
        $this->assertSame(
            $this->twig->render('dasherize', array('value' => 'fooBar')),
            'foo-bar'
        );
    }

    public function testDelimitFilter()
    {
        $this->assertSame(
            $this->twig->render('delimit', array('value' => 'fooBar')),
            'foo::bar'
        );
    }

    public function testHumanizeFilter()
    {
        $this->assertSame(
            $this->twig->render('humanize', array('value' => 'author_id')),
            'Author'
        );
    }

    public function testSlugifyFilter()
    {
        $this->assertSame(
            $this->twig->render('slugify', array('value' => 'Using strings like fòô bàř')),
            'using-strings-like-foo-bar'
        );
    }

    public function testTitleizeFilter()
    {
        $this->assertSame(
            $this->twig->render('titleize', array('value' => 'i like to watch television')),
            'I Like to Watch Television'
        );
    }

    public function testUnderscoredFilter()
    {
        $this->assertSame(
            $this->twig->render('underscored', array('value' => 'TestUCase')),
            'test_u_case'
        );
    }

    public function testSwapCaseExtraFilter()
    {
        $this->assertSame(
            $this->twig->render('swap_case', array('value' => 'SwapCase')),
            'sWAPcASE'
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
