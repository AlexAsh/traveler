<?php

namespace Traveler\Guessers\Namespaces;

use Traveler\Guessers\CanCamelizeTrait;

/**
 * Guesses full namespace by root namespace and uri path segments
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class CompositeNamespacesGuesser implements NamespacesGuesserInterface
{
    use CanCamelizeTrait;

    /**
     * @var string
     */
    private $root;

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
        $this->root      = $rootNamespace;
        $this->delimiter = $delimiter;
    }

    /**
     * Guesses full namespace by root namespace and uri path segments
     *
     * @param array $uriPathSegments
     *
     * @return string Full namespace guessed
     */
    public function guess(array $uriPathSegments)
    {
        if (count($uriPathSegments) < 3) {
            return $this->root;
        }

        $root              = (strlen($this->root) > 0) ? $this->root.'\\' : '';
        $namespaceSegments = array_slice($uriPathSegments, 0, -2);
        $namespaceChunks   = array_map([$this, 'camelize'], $namespaceSegments);
        $namespace         = $root.implode('\\', $namespaceChunks);

        return $namespace;
    }
}
