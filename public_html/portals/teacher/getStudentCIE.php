<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);
    if(!empty($request->subject_code) && !empty($request->usn))   {
        $db = new DBHelper();
        $conn = $db->getConnection();
        $subject_code = $request->subject_code;
        $usn = $request->usn;
        $query = "SELECT cie FROM marks 
                  WHERE subject_code='$subject_code' AND usn='$usn'";
        $data = [];
        if($res = $conn->query( $query)) {
            //$i = 0;
            $row = $res->fetch_assoc();
            $data['cie'] = $row['cie'];
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