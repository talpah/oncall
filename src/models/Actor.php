<?php

namespace Models;

class Actor extends BaseModel {
    
    protected $source = 'actors';
    protected $fields = array('email', 'name');
    
}