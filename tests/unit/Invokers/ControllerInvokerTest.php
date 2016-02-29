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
        $invoker->setClass('Unit\\Invokers\\ExampleController');
        $invoker->setMethod('getAction');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $result = $invoker();

        $expected = "Unit\\Invokers\\ExampleController::getAction(foo, bar)";
        $this->assertEquals($expected, $result);
    }

    public function testCall_WithNonExistingController_ThrowException404()
    {
        $invoker = new ControllerInvoker();
        $invoker->setClass('Unit\\Invokers\\BadexampleController');
        $invoker->setMethod('getAction');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $this->setExpectedException('\\Traveler\\Invokers\\Exceptions\\Exception404');
        $invoker();
    }

    public function testCall_WithNonExistingAction_ThrowException404()
    {
        $invoker = new ControllerInvoker();
        $invoker->setClass('Unit\\Invokers\\ExampleController');
        $invoker->setMethod('getNothing');
        $invoker->setParams(['a' => 'foo', 'b' => 'bar']);

        $this->setExpectedException('\\Traveler\\Invokers\\Exceptions\\Exception404');
        $invoker();
    }
}

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class ExampleController
{
    public function getAction($alpha, $betta)
    {
        return "Unit\\Invokers\\ExampleController::getAction($alpha, $betta)";
    }
}
