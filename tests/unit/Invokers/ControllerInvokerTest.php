<?php

namespace Unit\Invokers;

use Traveler\Invokers\ControllerInvoker;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class ControllerInvokerTest extends \PHPUnit_Framework_TestCase
{
    public function testCall_WithExistingController_CallController()
    {
        $invoker = new ControllerInvoker();
        $invoker->setClass('Unit\\Assets\\Controllers\\ExampleController');
        $invoker->setMethod('getAction');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $result = $invoker();

        $expected = "Unit\\Assets\\Controllers\\ExampleController::getAction(foo, bar)";
        $this->assertEquals($expected, $result);
    }

    public function testCall_WithNonExistingController_ThrowException404()
    {
        $invoker = new ControllerInvoker();
        $invoker->setClass('Unit\\Assets\\Controllers\\BadexampleController');
        $invoker->setMethod('getAction');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $this->setExpectedException('\\Traveler\\Invokers\\Exceptions\\Exception404');
        $invoker();
    }

    public function testCall_WithNonExistingAction_ThrowException404()
    {
        $invoker = new ControllerInvoker();
        $invoker->setClass('Unit\\Assets\\Controllers\\ExampleController');
        $invoker->setMethod('getNothing');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $this->setExpectedException('\\Traveler\\Invokers\\Exceptions\\Exception404');
        $invoker();
    }

    public function testCall_WithMultipleNamespacesAndSingleClassAvailable_FindControllerClass()
    {
        $invoker = new ControllerInvoker(['Unit\\Assets\\Controllers\\SubControllers']);
        $invoker->setClass('Unit\\Assets\\Controllers\\FooController');
        $invoker->setMethod('getAction');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $result = $invoker();

        $expected = "Unit\\Assets\\Controllers\\SubControllers\\FooController::getAction(foo, bar)";
        $this->assertEquals($expected, $result);
    }

    public function testCall_WithMultipleNamespacesAndMultipleClasses_FindClassWithAppropriateAction()
    {
        $invoker = new ControllerInvoker(['Unit\\Assets\\Controllers\\SubControllers']);
        $invoker->setClass('Unit\\Assets\\Controllers\\ExampleController');
        $invoker->setMethod('getMove');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $result = $invoker();

        $expected = "Unit\\Assets\\Controllers\\SubControllers\\ExampleController::getMove(foo, bar)";
        $this->assertEquals($expected, $result);
    }

    public function testCall_WithMultipleNamespacesAndMultipleClasses_PrioritizeFirstNamespace()
    {
        $invoker = new ControllerInvoker(['Unit\\Assets\\Controllers\\SubControllers']);
        $invoker->setClass('Unit\\Assets\\Controllers\\ExampleController');
        $invoker->setMethod('getAction');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $result = $invoker();

        $expected = "Unit\\Assets\\Controllers\\ExampleController::getAction(foo, bar)";
        $this->assertEquals($expected, $result);
    }

    public function testCall_WithMultipleNamespacesAndNoClass_ThrowException404()
    {
        $invoker = new ControllerInvoker(['Unit\\Assets\\Controllers\\SubControllers']);
        $invoker->setClass('Unit\\Assets\\Controllers\\BarController');
        $invoker->setMethod('getAction');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $this->setExpectedException('\\Traveler\\Invokers\\Exceptions\\Exception404');
        $invoker();
    }

    public function testCall_WithMultipleNamespacesAndNoMethod_ThrowException404()
    {
        $invoker = new ControllerInvoker(['Unit\\Assets\\Controllers\\SubControllers']);
        $invoker->setClass('Unit\\Assets\\Controllers\\FooController');
        $invoker->setMethod('getMove');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $this->setExpectedException('\\Traveler\\Invokers\\Exceptions\\Exception404');
        $invoker();
    }
}
