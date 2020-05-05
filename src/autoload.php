<?php
spl_autoload_register(function ($longClassName) {
    $recruitmentNamespace = '\Recruitment';
    if (strpos($longClassName, $recruitmentNamespace) == 0) {
        $className = substr($longClassName, strlen($recruitmentNamespace));
    } else {
        $className = $longClassName;
    }
    $projectSrcDir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src');
    $pathClassName = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $classFile = realpath($projectSrcDir . DIRECTORY_SEPARATOR . $pathClassName . ".php");

    if ($classFile !== false) {
        include_once $classFile;
        return true;
    }
    return false;
});