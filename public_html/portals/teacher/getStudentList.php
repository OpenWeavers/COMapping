<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);
    if(!empty($request->subject_code) && !empty($request->semester) && !empty($request->section_id))   {
        $db = new DBHelper();
        $conn = $db->getConnection();
        $email = $_SESSION['teacher_login'];
        $subject_code = $request->subject_code;
        $semester = $request->semester;
        $section_id = $request->section_id;
        $section_id = 'A';
        $semester = '5';
        $subject_code = 'CS540';
        $query = "SELECT U.usn, U.name FROM users as U, subjects as SUB WHERE U.section_id=SUB.section_id AND SUB.staff_id=(SELECT staff_id FROM staff where email='srinath@sjce.ac.in') AND SUB.subject_code='CS540' and U.section_id='A' and U.semester=5";
        $data = [];
        if($res = $conn->query( $query)) {
            $i = 0;
            while($row = $res->fetch_assoc())   {
                $data[$i]['usn'] = $row['usn'];
                $data[$i]['name'] = $row['name'];
                $i++;
            }
            echo json_encode(array("success" => true, "data" => json_encode($data)));
        }
        else    {
            echo json_encode(array("success" => false,"data" => "Nothing"));
        }
        $db->closeConnection($conn);
    }
    else    {
        echo json_encode(array("success" => false,"data" => "No subject code specified."));
    }
}
else    {
    echo json_encode(array("success" => false,"data" => "Empty POST request."));
}