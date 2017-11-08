<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$post_data = file_get_contents("php://input");
if(isset($post_data) && !empty($post_data))   {
    $request = json_decode($post_data);
    if(!empty($request->usn) && !empty($request->subject_code) &&
        !empty($request->cie))   {
        $db = new DBHelper();
        $conn = $db->getConnection();
        $usn = $request->usn;
        $subject_code = $request->subject_code;
        $cie = $request->cie;
        $query = "INSERT INTO marks(usn, subject_code, cie) 
                  VALUES('$usn', '$subject_code', '$cie')
                  ON DUPLICATE KEY UPDATE cie=VALUES(cie)";
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
