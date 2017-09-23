<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);
    if(!empty($request->subcode))   {
        $db = new DBHelper();
        $conn = $db->getConnection();
        $email = $_SESSION['teacher_login'];
        $subcode = $request->subcode;
        $query = "SELECT U.usn, U.name FROM users as U, subjects as SUB WHERE U.section_id=SUB.section_id AND SUB.staff_id='$email' AND SUB.subject_code='$subcode'";
        $data = [];
        if($res = $conn->query($query)) {
            $i = 0;
            while ($row = $res->fetch_row())    {
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