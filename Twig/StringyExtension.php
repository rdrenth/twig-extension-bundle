<?php

namespace Rdrenth\Bundle\TwigExtensionBundle\Twig;

/**
 * StringyExtension
 *
 * @author   Ronald Drenth <ronalddrenth@gmail.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     https://github.com/rdrenth/twig-extension-bundle
 */
class StringyExtension extends \Twig_Extension
{
    /**
     * @type array
     */
    private $filters;

    /**
     * @type string|null
     */
    private $encoding;

    /**
     * StringyExtension constructor.
     *
     * @param array $filters
     * @param null|string $encoding
     */
    public function __construct(array $filters = array(), $encoding = null)
    {
        $this->filters = $filters;
        $this->encoding = $encoding;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'StringyExtension';
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        if (empty($this->filters)) {
            return array();
        }

        $filters = array();
        foreach ($this->filters as $filterName => $methodName) {
            $filters[$filterName] = new \Twig_SimpleFilter($filterName, array('Stringy\StaticStringy', $methodName));
        }

        return $filters;
    }
}