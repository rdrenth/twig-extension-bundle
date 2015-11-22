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
     * StringyExtension constructor.
     *
     * @param array $filters
     */
    public function __construct(array $filters = array())
    {
        $this->filters = $filters;
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
