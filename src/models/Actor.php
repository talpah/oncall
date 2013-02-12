<?php

namespace Models;

class Actor extends BaseModel {

    protected $source = 'actors';
    protected $fields = array('id', 'email', 'name');

    protected function createDatabase() {
        return "CREATE TABLE Actors (id INTEGER PRIMARY KEY, name TEXT, email TEXT)";
    }

}