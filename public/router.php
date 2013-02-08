<?php

class Router {

    public $uri;
    public $controller;
    public $action;
    public $arguments=array();

    public function __construct($defaultController, $defaultAction) {
        $this->uri =
            $uri = $_SERVER['REQUEST_URI'];

        $uri = explode('/', $uri);

        switch (count($uri)) {
            case 2:
                $this->controller = $uri[1]?$uri[1]:$defaultController;
                $this->action = $defaultAction;
                break;
            case 3:
                $this->controller = $uri[1];
                $this->action = $uri[2]?$uri[2]:$defaultAction;
                break;
            default:
                $this->controller = $uri[1];
                $this->action = $uri[2];
                $this->arguments = array_filter(array_slice($uri, 3));
                break;
        }
    }

    public function dispatch(){
        try {
            $controllerPath = SOURCE.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$this->controller.'.php';

            if (!file_exists($controllerPath)) {
                $message = get_class($this).': Invalid controller "'.$this->controller.'" ('.$controllerPath.')';
                throw new \Exception($message);
            }
            $view = new Views\BaseView($this->controller, $this->action);

            $controllerName = 'Controllers\\'.$this->controller;
            $controller = new $controllerName;
            $controller->setView($view);
            $controller->setArguments($this->arguments);
            $actionOutput = $controller->run($this->action);
            $view->render($actionOutput);
        } catch(\Exception $exception) {
            require(SOURCE . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'exception.php');
        }
    }

}