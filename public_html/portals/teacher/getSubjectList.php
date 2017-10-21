<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$db = new DBHelper();
$conn = $db->getConnection();
$email = $_SESSION['teacher_login'];
$query = "SELECT SUB.subject_code, SUB.name, SUB.section_id, SUB.semester 
          from subjects AS SUB, staff 
          WHERE staff.staff_id=SUB.staff_id 
                AND staff.email='$email'";// AND staff.department=SEC.department
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