<?php

namespace Traveler\Invokers;

/**
 * Realization should be able to invoke controller
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
interface ControllerInvokerInterface
{
    /**
     * Realization should be able to invoke controller
     *
     * @return object Called controller object
     *
     * @throws \Traveler\Invokers\Exceptions\Exception404
     */
    public function __invoke();

    /**
     * @param string $class
     */
    public function setClass($class);

    /**
     * @return string
     */
    public function getClass();

    /**
     * @param string $method
     */
    public function setMethod($method);

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @param array $params
     */
    public function setParams(array $params);

    /**
     * @return array
     */
    public function getParams();
}
