<?php

namespace Views;

class BaseView {

    private $viewVars=array();
    protected $view='index.php';
    protected $templateDir='';
    protected $layout='default';
    protected $layoutDir='layouts';
    protected $viewDir='views';
    protected $contentType = 'text/html';

    public function __construct($controller, $action) {
        $this->viewDir = SOURCE . DIRECTORY_SEPARATOR . $this->viewDir;
        $this->layoutDir = $this->viewDir . DIRECTORY_SEPARATOR . $this->layoutDir;
        $this->templateDir = strtolower($controller);
        $this->view = $action.'.php';
    }

    public function __set($name, $value) {
        $this->viewVars[$name] = $value;
        return $value;
    }

    public function __get($name) {
        return isset($this->viewVars[$name]) ? $this->viewVars[$name]: null;
    }

    public function setResponseType($type) {
        switch ($type) {
            case 'ajax':
            case 'json':
                $this->setLayout(null);
                $this->setContentType('application/json');
                break;
            case 'text':
            case 'plain':
                $this->setLayout(null);
                $this->setContentType('text/plain');
                break;
            default:
                $this->setLayout('default');
                $this->setContentType('text/html');
        }
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function setContentType($contentType) {
        $this->contentType = $contentType;
    }

    public function render($defaultContent=null) {
        $viewPath = $this->viewDir. DIRECTORY_SEPARATOR . $this->templateDir.DIRECTORY_SEPARATOR.$this->view;

        $runView = function($_viewFile, $_viewVars) {
            extract($_viewVars);
            ob_start();
            require($_viewFile);
            $_content = ob_get_contents();
            ob_end_clean();
            return $_content;
        };

        if (!$defaultContent && !file_exists($viewPath)) {
            $message = get_class($this).': Cannot find view file "'.$this->templateDir.DIRECTORY_SEPARATOR.$this->view.'"';
            throw new \Exception($message);
        } elseif ($defaultContent && !file_exists($viewPath)) {
            $content = $defaultContent;
        } else {
            $content = $runView($viewPath, $this->viewVars);
        }

        header('Content-Type: '.$this->contentType);

        if ($this->layout) {
            require($this->layoutDir . DIRECTORY_SEPARATOR . $this->layout . '.php');
        } else {
            echo $content;
        }
    }

}