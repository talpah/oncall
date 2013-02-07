<?php

function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName=strtolower($fileName);
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require 'src/'.$fileName;
}

spl_autoload_register("autoload");

define('ROOT', realpath('.'));

use Controllers\OnCall;

$onCall = new OnCall();
