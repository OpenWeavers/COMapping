<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);
    if(!empty($request->noOfCo) && !empty($request->subject_code) &&
        !empty($request->section_id) && !empty($request->cie))   {
        $db = new DBHelper();
        $conn = $db->getConnection();
        $staff_id = $_SESSION['staff_id'];
        $no_of_co = $request->noOfCo;
        $cie = $request->cie;
        $subject_code = $request->subject_code;
        $section_id = $request->section_id;
        $query = "UPDATE subjects
                  SET no_of_co='$no_of_co', max_co='$cie'
                  WHERE subject_code='$subject_code'
                        AND section_id='$section_id'
                        AND staff_id='$staff_id'";
        if($res = $conn->query($query)) {
            echo json_encode(array("success" => true, "data" => "Query Success"));
        }
        else    {
            echo json_encode(array("success" => false,"data" => "Query Failure"));
        }
        $db->closeConnection($conn);
    }
    else    {
        echo json_encode(array("success" => false,"data" => "Required data not available"));
    }
}
else    {
    echo json_encode(array("success" => false,"data" => "Empty POST request."));
}