<?php

namespace Controllers;
use Models\Actor;

class OnCall {
    
    public function __construct() {
        echo 'OnCall';
        $this->getAssignments('now', 'never');
    }

    public function getAssignments($dateStart, $dateEnd) {
        $actors = new Actor();
        var_dump($actors->findAll());
    }

}