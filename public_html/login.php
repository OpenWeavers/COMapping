<?php
require 'com/config/DBHelper.php';
session_start();
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))   {
    $request = json_decode($postdata);
    if(!empty($request->email) && !empty($request->password) && !empty($request->category))  {
        $db = new DBHelper();
        $conn = $db->getConnection();
        $email = $conn->real_escape_string($request->email);
        $password = $conn->real_escape_string($request->password);
        $category = $conn->real_escape_string($request->category);
        $password = sha1($password);
        if($category == 'teacher') {
            $query = "SELECT * FROM staff WHERE email='$email' AND password='$password' and activated=1";
            $res = $conn->query($query);
            if($res->num_rows == 1) {
                $_SESSION['teacher_login'] = $email;
                $_SESSION['category'] = $category;
                //header('location:portals/teacher/');
                echo json_encode(array("success" => true, "data" => "Login success",
                    "url" => "portals/teacher/"));
                return;
            }
            else{
                echo json_encode(array("success" => false, "data" => "Teacher Login failure"));
                return;
            }
        }
        elseif ($category == 'hod')    {
            $query = "SELECT * FROM hod WHERE email='$email' AND password='$password' and activated=1";
            $res = $conn->query($query);
            if($res->num_rows == 1) {
                $_SESSION['hod_login'] = $email;
                $_SESSION['category'] = $category;
                //header('location:portals/hod/');
                echo json_encode(array("success" => true, "data" => "HOD Login success",
                    "url" => "portals/hod/"));
                return;
            }
            else{
                //echo "Invalid username or password";
                echo json_encode(array("success" => false, "data" => "HOD : Invalid username or password"));
                return;
            }
        }
        else    {
            echo json_encode(array("success" => false, "data" => "Invalid category"));
            return;
        }
    }
    else    {
        echo json_encode(array("success" => false, "data" => "Enter required details"));
        return;
    }
}
else    {
    echo json_encode(array("success" => false, "data" => "Empty request :("));
    return;
}
