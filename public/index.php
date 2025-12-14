<?php
session_start();
require_once __DIR__ . '/../app/Controllers/AuthControll.php';
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($uri === ''){
    header('Location: /register');
    exit;
}

$Authcontroll = new Authenticator;


if ($uri === 'login'){
    $Authcontroll->showLogin();
}elseif ($uri === 'login/attempt' && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $Authcontroll->authenticate();
}elseif ($uri === 'register'){
    $Authcontroll->showRegister();
}elseif ($uri === 'register/attempt' && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $Authcontroll->store();
}elseif ($uri === 'student/dashboard' && $_SESSION['role'] ?? '' === 0) {
    $Authcontroll -> showSdash();
}

else{
    echo "404 not found";
}

?>
