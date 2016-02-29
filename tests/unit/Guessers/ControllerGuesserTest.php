<?php

namespace Unit\Guessers;

use Traveler\Guessers\ControllerGuesser;
use Traveler\Invokers\ControllerInvoker;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class ControllerGuesserTest extends \PHPUnit_Framework_TestCase
{
    private $guesser;

    public function testGuess_WithTwoUriPathSegments_GetClassAndMethodGuessed()
    {
        $httpMethod = 'GET';
        $uriPathSegments = ['foo', 'bar'];

        $guessed = $this->guesser->guess($uriPathSegments, $httpMethod);

        $expected = [
            'class'  => 'Example\\Namespace\\FooController',
            'method' => 'getBar',
        ];
        $this->assertEquals($expected['class'],  $guessed->getClass());
        $this->assertEquals($expected['method'], $guessed->getMethod());
    }

    public function testGuess_WithOneUriPathSegment_GetClassAndDefaultMethodGuessed()
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
        $this->assertEquals($expected['class'],  $guessed->getClass());
        $this->assertEquals($expected['method'], $guessed->getMethod());
    }

    public function testGuess_WithNoUriPathSegments_GetDefaultClassAndDefaultMethodGuessed()
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
        $this->assertEquals($expected['class'],  $guessed->getClass());
        $this->assertEquals($expected['method'], $guessed->getMethod());
    }

    public function testGuess_WithUnsupportedHttpMethod_ThrowDomainException()
    {
        $supportedHttpMethods = ['GET', 'POST'];
        $this->guesser->setSupportedHttpMethods($supportedHttpMethods);

        $httpMethod = 'PUT';
        $uriPathSegments = ['foo', 'bar'];

        $this->setExpectedException('\\DomainException');
        $this->guesser->guess($uriPathSegments, $httpMethod);
    }

    public function setUp()
    {
        parent::setUp();

        $controllerNamespace = 'Example\\Namespace';
        $controllerInvoker = new ControllerInvoker();

        $this->guesser = new ControllerGuesser($controllerNamespace, $controllerInvoker);
    }
}
