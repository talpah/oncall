<?php
define('ROOT', dirname(dirname(realpath(__FILE__))));
define('SOURCE', dirname(dirname(realpath(__FILE__))).DIRECTORY_SEPARATOR.'src');

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

    require SOURCE.DIRECTORY_SEPARATOR.$fileName;
}

spl_autoload_register("autoload");