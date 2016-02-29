<?php

namespace Traveler\Invokers;

/**
 * Invokes controller by class, method, and params given
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class ControllerInvoker implements ControllerInvokerInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $params;

    /**
     * @var object
     */
    private $controllerObject = NULL;

    /**
     * Invokes controller by class, method, and params given; throws exception if no such controller
     *
     * @return mixed controller invoke result
     *
     * @throws \Traveler\Invokers\Exceptions\Exception404
     */
    public function __invoke()
    {
        $this->checkController();

        $this->controllerObject = new $this->class();

        return call_user_func_array([$this->controllerObject, $this->method], $this->params);
    }

    /**
     * Check if both class and method are reachable
     *
     * @throws \Traveler\Invokers\Exceptions\Exception404
     */
    private function checkController()
    {
        if (!class_exists($this->class)) {
            throw new Exceptions\Exception404("No such controller class {$this->class}");
        }

        if (!method_exists($this->class, $this->method)) {
            throw new Exceptions\Exception404("No such action {$this->method} in {$this->class}");
        }
    }

    /**
     * @param string $class
     *
     * @codeCoverageIgnore
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $method
     *
     * @codeCoverageIgnore
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param array $params
     *
     * @codeCoverageIgnore
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return object returns controller object, created in __invoke()
     *
     * @codeCoverageIgnore
     */
    public function getControllerObject()
    {
        return $this->controllerObject;
    }
}
