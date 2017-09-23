<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$db = new DBHelper();
$conn = $db->getConnection();
$email = $_SESSION['teacher_login'];
$query = "SELECT SUB.subject_code, SUB.name from subjects AS SUB, sections AS SEC, staff WHERE SUB.section_id=SEC.section_id AND staff.department=SEC.department AND staff.staff_id=SUB.staff_id AND staff.email='$email'";
$data = [];
if($res = $conn->query( $query)) {
    $i = 0;
    while($row = $res->fetch_assoc())   {
        $data[$i]['subject_code'] = $row['subject_code'];
        $data[$i]['name'] = $row['name'];
        $i++;
    }
    echo json_encode(array("success" => true, "data" => json_encode($data)));
}
else    {
    echo json_encode(array("success" => false,"data" => "Nothing"));
}