<?php
require 'com/config/DBHelper.php';
session_start();
if(!empty(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))
    && !empty(filter_input(INPUT_POST, "password"))
    && !empty(filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRIPPED)))  {
    $db = new DBHelper();
    $conn = $db->getConnection();
    $email = $conn->real_escape_string(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
    $password = $conn->real_escape_string(filter_input(INPUT_POST, "password"));
    $category = $conn->real_escape_string(filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRIPPED));
    $password = sha1($password);

    if($category == 'teacher') {
        $query = "SELECT * FROM staff WHERE email='$email' AND password='$password' and activated=1";
        $res = $conn->query($query);
        if($res->num_rows == 1) {
            $_SESSION['teacher_login'] = $email;
            $_SESSION['category'] = $category;
            header('location:portals/teacher/');
        }
        else{
            echo "Invalid username or password";
            return;
        }
    }
    elseif ($category == 'hod')    {
        $query = "SELECT * FROM hod WHERE email='$email' AND password='$password' and activated=1";
        $res = $conn->query($query);
        if($res->num_rows == 1) {
            $_SESSION['hod_login'] = $email;
            $_SESSION['category'] = $category;
            header('location:portals/hod/');
        }
        else{
            echo "Invalid username or password";
            return;
        }
    }
    else    {
        echo "Invalid ****ing category";
    }
}