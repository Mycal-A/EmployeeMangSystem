<?php

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value) {
    return $_SERVER['REQUEST_URI'] === $value;
}


function view($path, $attributes = [])
{
    extract($attributes);

    require ($path);
}

function authorize($condition, $status = 403)
{
    if (! $condition) {
        abort($status);
    }

    return true;
}


function login($user)
{
    session_start();
    $_SESSION['user'] = [
        'email' => $user['email']
    ];
    
    session_regenerate_id(true);
}

function logout()
{
    $_SESSION = [];
    session_destroy();

    $params = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);

}