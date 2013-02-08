<?php

namespace Models;

class ActorOrder extends BaseModel {

    protected $source = 'actors_order';
    protected $fields = array('order', 'actor_id', 'first_run');

}