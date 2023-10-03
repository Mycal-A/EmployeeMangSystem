<?php
require "Database.php";
require "functions.php";
require "Validator.php";
$config = require("config.php");
$db = new Database($config['database']);

$email = $_POST['Email'];
$password = $_POST['Password'];
//dd($password);

$errors = [];
if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password)) {
    $errors['password'] = 'Please provide a valid password.';
}

if (! empty($errors)) {
    return view('session/login.view.php', [
        'errors' => $errors
    ]);
}

//For Admin Login
if($email==="admin@gmail.com" && $password==="admin"){
    
    login([
        'email' => 'admin@gmail.com'
    ]);
    
    header('location: /adminHome');
        exit();
}

$user = $db->query('select * from employee where Email = :email', [
    'email' => $email
])->find();

// $name=$user['Name'];
//dd($user['Access']);

if ($user !== false) {
    if ($password === $user['Password']) {
        if($user['Access']==1){
            
        //dd($user['Employee_ID']);
        // Valid user found
        login([
            'email' => $email
        ]);

        //dd($_SESSION['user']);
        $_SESSION['id']=$user['Employee_ID'];
        $id=$_SESSION['id'];
        // dd($id);
        $email=$_SESSION['user'];
        header('location: empHome');
        exit();

        }else{
            header('Location: 403.php');
            exit();
        }



    } else {
        // Incorrect password
        return view('session/login.view.php', [
            'errors' => [
                'password' => 'Incorrect password.'
            ]
        ]);
    }
} else {
    // No user found with the provided email
    return view('session/login.view.php', [
        'errors' => [
            'email' => 'No matching account found for that email address.'
        ]
    ]);
}

//(password_verify())