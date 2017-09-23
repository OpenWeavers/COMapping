<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))   {
    $request = json_decode($postdata);
    $db = new DBHelper();
    $conn = $db->getConnection();
    $name = $request->name;
    $cie = $request->cie;
    $query = "insert into students values ('$name','$cie')";
    $res = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($res);
    echo $data."done";
}
$db->closeConnection($conn);