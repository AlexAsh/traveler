<?php

namespace Integration\Guessers;

use Traveler\Guessers\Namespaces\NamespacesGuesser;
use Traveler\Guessers\Classes\ClassesGuesser;
use Traveler\Guessers\Methods\MethodsGuesser;
use Traveler\Guessers\ControllerGuesser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class ControllerGuesserTest extends \PHPUnit_Framework_TestCase
{
    public function testGuess_WithManyUriPathSegments_GuessNamespaceClassAndMethod()
    {
        $rootNamespace   = 'Root\\Space';
        $uriPathSegments = ['foo', 'bar', 'baz', 'qux'];
        $httpMethod      = 'GET';

        $namespaceGuesser  = new NamespacesGuesser($rootNamespace);
        $classGuesser      = new ClassesGuesser();
        $methodGuesser     = new MethodsGuesser();
        $controllerGuesser = new ControllerGuesser($namespaceGuesser, $classGuesser, $methodGuesser);

        $invoker = $controllerGuesser->guess($uriPathSegments, $httpMethod);

        $expected = [
            'invoker_class'     => 'Traveler\\Invokers\\ControllerInvoker',
            'controller_class'  => 'Root\\Space\\Foo\\Bar\\BazController',
            'controller_method' => 'getQux',
        ];
        $this->assertEquals($expected['invoker_class'],     get_class($invoker));
        $this->assertEquals($expected['controller_class'],  $invoker->getClass());
        $this->assertEquals($expected['controller_method'], $invoker->getMethod());
    }

    public function testGuess_WithTwoUriPathSegmentsAndEmptyNamespace_GuessNotNamespacedClassAndMethod()
    {
        $rootNamespace   = '';
        $uriPathSegments = ['foo', 'bar'];
        $httpMethod      = 'GET';

        $namespaceGuesser  = new NamespacesGuesser($rootNamespace);
        $classGuesser      = new ClassesGuesser();
        $methodGuesser     = new MethodsGuesser();
        $controllerGuesser = new ControllerGuesser($namespaceGuesser, $classGuesser, $methodGuesser);

        $invoker = $controllerGuesser->guess($uriPathSegments, $httpMethod);

        $expected = [
            'invoker_class'     => 'Traveler\\Invokers\\ControllerInvoker',
            'controller_class'  => 'FooController',
            'controller_method' => 'getBar',
        ];
        $this->assertEquals($expected['invoker_class'],     get_class($invoker));
        $this->assertEquals($expected['controller_class'],  $invoker->getClass());
        $this->assertEquals($expected['controller_method'], $invoker->getMethod());
    }

}
