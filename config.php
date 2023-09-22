<?php

$con=mysqli_connect("localhost","root","","empmng");

if(!$con){
    die("ERROR");
}


return [
    'database' => [
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'empmng',
        'charset' => 'utf8mb4'
    ],

    //
];

?>