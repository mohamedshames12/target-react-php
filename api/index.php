<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=utf-8");
    header("Access-Control-Allow-Headers:Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
   
    include "config.php";

    $user = json_decode(file_get_contents('php://input') );

    $fname = $user->first_name;
    $lname = $user->last_name;
    $email = $user->email;
    $password = sha1($user->password);

    $verify_email = $conn->prepare("SELECT * FROM users WHERE email =?");
    $verify_email->execute([$email]);

    if($verify_email->rowCount() > 0){
        echo "email already taken!";
    }else {
        $insert_email = $conn->prepare("INSERT INTO users(fname, lname , email , password) VALUES(?,?,?,?)");
        $insert_email->execute([$fname, $lname, $email, $password]);
        echo "email created successfully!";
    }

?>
