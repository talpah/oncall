<?php

namespace Controllers;
use Models\Actor;

class OnCall extends BaseController {


    public function index() {

    }

    public function getActorsJson() {
        $this->view->setLayout(null);
        $actors = new Actor();
        return var_export($actors->findAll(), true);
    }

}