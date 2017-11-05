<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$db = new DBHelper();
$conn = $db->getConnection();
$email = $_SESSION['teacher_login'];
/*$query = "SELECT subject_code, name, section_id, semester
          from subjects
          WHERE staff_id={$_SESSION['staff_id']}";
*/
$query = "SELECT s.subject_code, s.subject_name, s.section_id, s.semester
            FROM subject_teachers AS st INNER JOIN subject AS s
                  ON (st.subject_code=s.subject_code AND st.section_id=s.section_id)
            WHERE st.staff_id={$_SESSION['staff_id']}";
$data = [];
if($res = $conn->query( $query)) {
    $i = 0;
    while($row = $res->fetch_assoc())   {
        $data[$i]['subject_code'] = $row['subject_code'];
        $data[$i]['name'] = $row['subject_name'];
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