<?php

namespace Rdrenth\Bundle\TwigExtensionBundle\Twig;

/**
 * Class StringyExtension
 *
 * @author   Ronald Drenth <ronalddrenth@gmail.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     https://github.com/rdrenth/twig-extension-bundle
 */
final class StringyExtension extends \Twig_Extension
{
    /**
     * @var array
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
        if (count($this->filters) === 0) {
            return array();
        }

        $filters = array();
        foreach ($this->filters as $filterName => $methodName) {
            $filters[$filterName] = new \Twig_SimpleFilter($filterName, array('Stringy\StaticStringy', $methodName));
        }

        return $filters;
    }
}
