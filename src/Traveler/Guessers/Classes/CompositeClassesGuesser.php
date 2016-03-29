<?php

namespace Traveler\Guessers\Classes;

use Traveler\Guessers\CanCamelizeTrait;

/**
 * Guesses controller class name without namespace
 *
 * Converts such-uri-path-segment to SuchUriPathSegmentController class name
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class CompositeClassesGuesser implements ClassesGuesserInterface
{
    use CanCamelizeTrait;

    /**
     * @var string
     */
    private $defaultSegment;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @param string $defaultSegment
     * @param string $delimiter
     */
    public function __construct($defaultSegment = 'index', $delimiter = '-')
    {
        $this->defaultSegment = $defaultSegment;
        $this->delimiter      = $delimiter;
    }

    /**
     * Guesses multi-word controller class name, e.g. LongExampleController
     *
     * @param array $uriPathSegments
     *
     * @return string
     */
    public function guess(array $uriPathSegments)
    {
        $lastSegments = array_slice($uriPathSegments, -2);
        $segment      = (count($lastSegments) > 0) ? $lastSegments[0] : $this->defaultSegment;
        $class        = $this->camelize($segment).'Controller';

        return $class;
    }
}
