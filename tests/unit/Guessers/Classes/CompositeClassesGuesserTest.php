<?php

namespace Unit\Guessers\Classes;

use Traveler\Guessers\Classes\CompositeClassesGuesser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class CompositeClassesGuesserTest extends \PHPUnit_Framework_TestCase
{
    public function testGuess_WithManyUriPathSegments_GuessClassFromPenultimateSegment()
    {
        $guesser = $this->getGuesser();
        $segments = ['sales', 'controllers', 'greedy-customer', 'cart'];

        $classname = $guesser->guess($segments);

        $this->assertEquals('GreedyCustomerController', $classname);
    }

    public function testGuess_WithOneUriPathSegment_GuessClassFromSegment()
    {
        $guesser = $this->getGuesser();
        $segments = ['customer-gold-digging'];

        $classname = $guesser->guess($segments);

        $this->assertEquals('CustomerGoldDiggingController', $classname);
    }

    public function testGuess_WithZeroUriPathSegments_GuessClassFromDefaultSegment()
    {
        $guesser = $this->getGuesser('customer-threaten');
        $segments = [];

        $classname = $guesser->guess($segments);

        $this->assertEquals('CustomerThreatenController', $classname);
    }

    public function testGuess_WithCustomDelimitedUriPathSegments_GuessClassConsideringDelimiter()
    {
        $guesser = $this->getGuesser('index', '_');
        $segments = ['sales', 'controllers', 'customer_gone', 'cart'];

        $classname = $guesser->guess($segments);

        $this->assertEquals('CustomerGoneController', $classname);
    }

    protected function getGuesser($defaultSegment = 'index', $delimiter = '-')
    {
        return new CompositeClassesGuesser($defaultSegment, $delimiter);
    }
}
