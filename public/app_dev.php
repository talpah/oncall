<?php
ini_set('display_errors', 1);
require 'bootstrap.php';
require 'router.php';

$router = new Router('OnCall', 'index');

$router->dispatch();