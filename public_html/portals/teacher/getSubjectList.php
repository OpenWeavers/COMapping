<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$db = new DBHelper();
$conn = $db->getConnection();
$email = $_SESSION['teacher_login'];
$query = "SELECT subject_code, name, section_id, semester 
          from subjects
          WHERE staff_id={$_SESSION['staff_id']}";
$data = [];
if($res = $conn->query( $query)) {
    $i = 0;
    while($row = $res->fetch_assoc())   {
        $data[$i]['subject_code'] = $row['subject_code'];
        $data[$i]['name'] = $row['name'];
        $data[$i]['section_id'] = $row['section_id'];
        $data[$i]['semester'] = $row['semester'];
        $i++;
    }
    echo json_encode(array("success" => true, "data" => json_encode($data)));
}
else    {
    echo json_encode(array("success" => false,"data" => "Nothing"));
}
$db->closeConnection($conn);