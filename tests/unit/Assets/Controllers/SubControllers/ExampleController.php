<?php

namespace Unit\Assets\Controllers\SubControllers;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class ExampleController
{
    public function getMove($alpha, $betta)
    {
        return "Unit\\Assets\\Controllers\\SubControllers\\ExampleController::getMove($alpha, $betta)";
    }

    public function getAction($alpha, $betta)
    {
        return "Unit\\Assets\\Controllers\\SubControllers\\ExampleController::getAction($alpha, $betta)";
    }
}
