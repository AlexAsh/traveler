<?php

namespace Traveler\Guessers\Namespaces;

use Traveler\Guessers\CanCamelizeTrait;

/**
 * Guesses full namespace by root namespace and multi-word uri path segments
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class CompositeNamespacesGuesser extends BaseNamespacesGuesser
{
    use CanCamelizeTrait;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @param string $rootNamespace
     * @param string $delimiter
     */
    public function __construct($rootNamespace, $delimiter = '-')
    {
        parent::__construct($rootNamespace);

        $this->delimiter = $delimiter;
    }

    /**
     * Guesses full namespace by root namespace and multi-word uri path segments
     *
     * @param array $uriPathSegments
     *
     * @return string Full namespace guessed
     */
    public function guess(array $uriPathSegments)
    {
        return $this->buildNamespace($uriPathSegments, [$this, 'camelize']);
    }
}
