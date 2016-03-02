<?php

namespace Unit\Guessers\Methods;

use Traveler\Guessers\Methods\MethodsGuesser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class MethodsGuesserTest extends \PHPUnit_Framework_TestCase
{
    public function testGuess_WithManyUriPathSegmentsAndHttpMethod_GuessMethodFromLastSegment()
    {
        $uriPathSegments = ['foo', 'bar', 'baz', 'qux'];
        $httpMethod = 'GET';
        $guesser = new MethodsGuesser();

        $guessed = $guesser->guess($uriPathSegments, $httpMethod);

        $this->assertEquals('getQux', $guessed);
    }

    public function testGuess_WithLessThanTwoUriPathSegmentsAndHttpMethod_GuessMethodFromDefaultSegment()
    {
        $uriPathSegments = ['foo'];
        $httpMethod = 'GET';
        $guesser = new MethodsGuesser('index');

        $guessed = $guesser->guess($uriPathSegments, $httpMethod);

        $this->assertEquals('getIndex', $guessed);
    }

    public function testGuess_WithUnsupportedHttpMethod_ThrowDomainException()
    {
        $uriPathSegments = ['foo', 'bar'];
        $httpMethod = 'PUT';
        $guesser = new MethodsGuesser('index', ['GET', 'POST']);

        $this->setExpectedException('\\DomainException');
        $guesser->guess($uriPathSegments, $httpMethod);
    }
}
