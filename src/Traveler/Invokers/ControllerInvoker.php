<?php

namespace Traveler\Invokers;

use Traveler\Invokers\Exceptions\Exception404;

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
    private $controllerObject = null;

    /**
     * @var array
     */
    private $extraNamespaces;

    /**
     * @param array $extraNamespaces
     *
     * @codeCoverageIgnore
     */
    public function __construct(array $extraNamespaces = [])
    {
        $this->extraNamespaces = $extraNamespaces;
    }

    /**
     * Invokes controller by class, method, and params given; throws exception if no such controller
     *
     * @return mixed controller invoke result
     *
     * @throws \Traveler\Invokers\Exceptions\Exception404
     */
    public function __invoke()
    {
        if (!class_exists($this->class) || !method_exists($this->class, $this->method)) {
            $this->findController();
        }

        $this->controllerObject = new $this->class();

        return call_user_func_array([$this->controllerObject, $this->method], $this->params);
    }

    /**
     * Looks for controller across multiple namespaces
     *
     * @throws \Traveler\Invokers\Exceptions\Exception404
     */
    private function findController()
    {
        $className = end(explode('\\', $this->class));
        $class     = '';

        foreach ($this->extraNamespaces as $extraNamespace) {
            if (class_exists($extraNamespace.'\\'.$className) &&
                    method_exists($extraNamespace.'\\'.$className, $this->method)) {
                $class       = $extraNamespace.'\\'.$className;
                $this->class = $class;

                break;
            }
        }

        if ($class === '') {
            throw new Exception404("No such controller {$this->class}::{$this->method}");
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
