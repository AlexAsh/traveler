<?php

namespace Unit\Guessers\Namespaces;

use Traveler\Guessers\Namespaces\CompositeNamespacesGuesser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class CompositeNamespacesGuesserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $rootNamespace;

    public function testGuess_WithFourUriPathSegments_GetTwoLeveledNamespaceConcatToRoot()
    {
        $guesser = $this->getGuesser();
        $segments = ['sales-west', 'controllers', 'customer', 'cart'];

        $namespace = $guesser->guess($segments);

        $this->assertEquals('Root\\Space\\SalesWest\\Controllers', $namespace);
    }

    public function testGuess_WithThreeUriPathSegments_GetOneLeveledNamespaceConcatToRoot()
    {
        $guesser = $this->getGuesser();
        $segments = ['payment-controllers', 'customer', 'cart'];

        $namespace = $guesser->guess($segments);

        $this->assertEquals('Root\\Space\\PaymentControllers', $namespace);
    }

    public function testGuess_WithTwoUriPathSegments_GetRootNamespace()
    {
        $guesser = $this->getGuesser();
        $segments = ['customer', 'cart'];

        $namespace = $guesser->guess($segments);

        $this->assertEquals('Root\\Space', $namespace);
    }

    public function testGuess_WithCustomDelimitedUriPathSegments_GetAppropriateNamespace()
    {
        $guesser = $this->getGuesser('_');
        $segments = ['sales_west', 'controllers', 'customer', 'cart'];

        $namespace = $guesser->guess($segments);

        $this->assertEquals('Root\\Space\\SalesWest\\Controllers', $namespace);
    }

    protected function getGuesser($delimiter = '-')
    {
        return new CompositeNamespacesGuesser($this->rootNamespace, $delimiter);
    }

    public function setUp()
    {
        parent::setUp();

        $this->rootNamespace = 'Root\\Space';
    }
}
