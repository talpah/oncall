<?php

namespace Controllers;

class BaseController {

    protected $view=null;
    protected $argumentBag=array();

    public function __construct() {

    }

    public function run($action) {
        if (!method_exists($this, $action)) {
            $message = get_class($this).': Invalid action specified "'.$action.'"';
            throw new \Exception($message);
        }
        $method = new \ReflectionMethod($this, $action);
        $requiredParams = $method->getNumberOfRequiredParameters();
        if (count($this->argumentBag)<$requiredParams) {
            $message = get_class($this).': Action "'.$action.'" reuqires '.$requiredParams.' parameters, only '.count($this->argumentBag).' given';
            throw new \Exception($message);
        }
        return $method->invokeArgs($this, $this->argumentBag);
    }

    public function setView($view) {
        $this->view = $view;
    }

    public function setArguments($arguments) {
        $this->argumentBag = $arguments;
    }

    public function getArguments() {
        return $this->argumentBag;
    }


}