<?php

function url($path = '') {
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    $basePath = ($scriptName !== '/' && $scriptName !== '\\') ? $scriptName : '';
    return $basePath . '/' . ltrim($path, '/');
}

function asset($path = '') {
    return url($path);
}

function redirect($path) {
    header('Location: ' . url($path));
    exit;
}

?>