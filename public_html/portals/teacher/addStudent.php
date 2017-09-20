<?php
/**
 * Created by PhpStorm.
 * User: vinyas
 * Date: 9/17/17
 * Time: 4:54 PM
 */
require 'com/config/DBHelper.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))   {
    $request = json_decode($postdata);
    $db = new DBHelper();
    $conn = $db->getConnection();
    $name = $request->name;
    $cie = $request->cie;
    $query = "insert into students values ('$name', '$cie')";
    $res = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($res);
    echo $data."done";
}
