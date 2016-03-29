<?php

namespace Traveler\Guessers\Classes;

/**
 * Guesses controller class name without namespace
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class ClassesGuesser implements ClassesGuesserInterface
{
    /**
     * @var string
     */
    private $defaultSegment;

    /**
     * @param string $defaultSegment Segment to use, when uri path segments array is zero-length.
     */
    public function __construct($defaultSegment = 'default')
    {
        $this->defaultSegment = $defaultSegment;
    }

    /**
     * Guesses two-word controller class name, e.g. ExampleController, not LongExampleController
     *
     * @param array $uriPathSegments
     *
     * @return string
     */
    public function guess(array $uriPathSegments)
    {
        $lastSegments = array_slice($uriPathSegments, -2);
        $segment      = (count($lastSegments) > 0) ? $lastSegments[0] : $this->defaultSegment;
        $class        = ucfirst($segment).'Controller';

        return $class;
    }
}
