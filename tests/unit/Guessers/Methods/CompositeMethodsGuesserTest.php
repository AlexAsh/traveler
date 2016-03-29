<?php

namespace Unit\Guessers\Methods;

use Traveler\Guessers\Methods\CompositeMethodsGuesser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class CompositeMethodsGuesserTest extends \PHPUnit_Framework_TestCase
{
    public function testGuess_WithManyUriPathSegmentsAndHttpMethod_GuessMethodFromLastSegment()
    {
        $uriPathSegments = ['foo', 'bar', 'baz', 'qux-example'];
        $httpMethod = 'GET';
        $guesser = $this->getGuesser();

        $guessed = $guesser->guess($uriPathSegments, $httpMethod);

        $this->assertEquals('getQuxExample', $guessed);
    }

    public function testGuess_WithLessThanTwoUriPathSegmentsAndHttpMethod_GuessMethodFromDefaultSegment()
    {
        $uriPathSegments = ['foo'];
        $httpMethod = 'GET';
        $guesser = $this->getGuesser('index-default');

        $guessed = $guesser->guess($uriPathSegments, $httpMethod);

        $this->assertEquals('getIndexDefault', $guessed);
    }

    public function testGuess_WithUripathSegmentsAndHttpMethod_EnsureValidateHttpMethodCalledWithHttpMethod()
    {
        $uriPathSegments = ['foo', 'bar-baz'];
        $httpMethod = 'GET';
        $guesser = \Mockery::mock('\\Traveler\\Guessers\\Methods\\CompositeMethodsGuesser[validateHttpMethod]')
            ->shouldReceive('validateHttpMethod')
            ->with($httpMethod)
            ->once()
            ->mock();

        $guesser->guess($uriPathSegments, $httpMethod);

        \Mockery::close();
        $this->addToAssertionCount(1);
    }

    public function testGuess_WithCustomDelimitedUriPathSegments_GuessMethodConsideringDelimiter()
    {
        $uriPathSegments = ['foo', 'bar', 'baz', 'qux_example-redunant'];
        $httpMethod = 'GET';
        $guesser = $this->getGuesser('index', [], '_');

        $guessed = $guesser->guess($uriPathSegments, $httpMethod);

        $this->assertEquals('getQuxExample-redunant', $guessed);
    }

    protected function getGuesser($defaultSegment = 'default', array $httpMethods = [], $delimiter = '-')
    {
        return new CompositeMethodsGuesser($defaultSegment, $httpMethods, $delimiter);
    }
}
