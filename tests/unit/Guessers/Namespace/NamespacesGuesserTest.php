<?php

namespace Unit\Guessers\Namespaces;

use Traveler\Guessers\Namespaces\NamespacesGuesser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class NamespacesGuesserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Traveler\Guessers\Namespaces\NamespacesGuesser
     */
    private $guesser;

    public function testGuess_WithFourUriPathSegments_GetTwoLeveledNamespaceConcatToRoot()
    {
        $segments = ['sales', 'controllers', 'customer', 'cart'];

        $namespace = $this->guesser->guess($segments);

        $this->assertEquals('Root\\Space\\Sales\\Controllers', $namespace);
    }

    public function testGuess_WithThreeUriPathSegments_GetOneLeveledNamespaceConcatToRoot()
    {
        $segments = ['controllers', 'customer', 'cart'];

        $namespace = $this->guesser->guess($segments);

        $this->assertEquals('Root\\Space\\Controllers', $namespace);
    }

    public function testGuess_WithTwoUriPathSegments_GetRootNamespace()
    {
        $segments = ['customer', 'cart'];

        $namespace = $this->guesser->guess($segments);

        $this->assertEquals('Root\\Space', $namespace);
    }

    public function setUp()
    {
        parent::setUp();

        $rootNamespace = 'Root\\Space';
        $this->guesser = new NamespacesGuesser($rootNamespace);
    }
}
