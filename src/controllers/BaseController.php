<?php

namespace Controllers;

class BaseController {

    protected $view=null;

    public function __construct() {

    }

    public function run($action) {
        if (!method_exists($this, $action)) {
            $message = get_class($this).': Invalid action specified "'.$action.'"';
            throw new \Exception($message);
        }
        return $this->$action();
    }

    public function setView($view) {
        $this->view = $view;
    }


}