<?php

namespace Traveler\Guessers\Namespaces;

use Traveler\Guessers\CanCamelizeTrait;

/**
 * Guesses full namespace by root namespace and multi-word uri path segments according to package hierarchy
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class HierarchicalNamespacesGuesser extends BaseNamespacesGuesser
{
    use CanCamelizeTrait;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var string
     */
    private $subpackageOffset;

    /**
     * @var string
     */
    private $controllerOffset;

    /**
     * @param string $rootNamespace
     * @param string $subpackageOffset
     * @param string $controllerOffset
     * @param string $delimiter
     */
    public function __construct($rootNamespace = '', $subpackageOffset = '', $controllerOffset = '', $delimiter = '-')
    {
        parent::__construct($rootNamespace);

        $this->subpackageOffset = $subpackageOffset;
        $this->controllerOffset = $controllerOffset;
        $this->delimiter        = $delimiter;
    }

    /**
     * Guesses full namespace by root namespace and multi-word uri path segments according to package hierarchy
     *
     * @param array $uriPathSegments
     *
     * @return string Full namespace guessed
     */
    public function guess(array $uriPathSegments)
    {
        return $this->buildNamespace(
            $uriPathSegments,
            [$this, 'camelize'],
            '\\'.$this->subpackageOffset.'\\',
            $this->controllerOffset
        );
    }
}
