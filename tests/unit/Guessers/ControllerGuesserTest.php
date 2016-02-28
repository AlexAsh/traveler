<?php

namespace Unit\Guessers;

use Traveler\Guessers\ControllerGuesser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class ControllerGuesserTest extends \PHPUnit_Framework_TestCase
{
    private $guesser;

    public function testGuess_withTwoUriPathSegments_GetClassAndMethodGuessed()
    {
        $httpMethod = 'GET';
        $uriPathSegments = ['foo', 'bar'];

        $guessed = $this->guesser->guess($uriPathSegments, $httpMethod);

        $expected = [
            'class'  => 'Example\\Namespace\\FooController',
            'method' => 'getBar',
        ];
        $this->assertEquals($expected, $guessed);
    }

    public function testGuess_withOneUriPathSegment_GetClassAndDefaultMethodGuessed()
    {
        $httpMethod = 'GET';
        $uriPathSegments = ['foo'];
        $defaultMethodSegment = 'default';
        $this->guesser->setDefaultMethodSegment($defaultMethodSegment);

        $guessed = $this->guesser->guess($uriPathSegments, $httpMethod);

        $expected = [
            'class'  => 'Example\\Namespace\\FooController',
            'method' => 'getDefault',
        ];
        $this->assertEquals($expected, $guessed);
    }

    public function testGuess_withNoUriPathSegments_GetDefaultClassAndDefaultMethodGuessed()
    {
        $httpMethod = 'GET';
        $uriPathSegments = [];

        $defaultMethodSegment = 'default';
        $this->guesser->setDefaultMethodSegment($defaultMethodSegment);
        $defaultClassSegment = 'empty';
        $this->guesser->setDefaultClassSegment($defaultClassSegment);

        $guessed = $this->guesser->guess($uriPathSegments, $httpMethod);

        $expected = [
            'class'  => 'Example\\Namespace\\EmptyController',
            'method' => 'getDefault',
        ];
        $this->assertEquals($expected, $guessed);
    }

    public function testGuess_withUnsupportedHttpMethod_ThrowDomainException()
    {
        $supportedHttpMethods = ['GET', 'POST'];
        $this->guesser->setSupportedHttpMethods($supportedHttpMethods);

        $httpMethod = 'PUT';
        $uriPathSegments = ['foo', 'bar'];

        // No $this->expectException() because of phpunit version 4.8
        try {
            $this->guesser->guess($uriPathSegments, $httpMethod);
        } catch (\Exception $e) {
            $failedMessage = "Failed to assert that ".get_class($e)." is \DomainException";
            $this->assertTrue($e instanceof \DomainException, $failedMessage);
            return;
        }

        $this->fail("No exception throwed");
    }

    public function setUp()
    {
        parent::setUp();

        $controllerNamespace = 'Example\\Namespace';
        $this->guesser = new ControllerGuesser($controllerNamespace);
    }
}
