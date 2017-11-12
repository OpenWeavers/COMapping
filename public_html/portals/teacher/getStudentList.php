<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$post_data = file_get_contents("php://input");
if(isset($post_data) && !empty($post_data)) {
    $request = json_decode($post_data);
    if(!empty($request->subject_code) && !empty($request->semester) && !empty($request->section_id))   {
        $db = new DBHelper();
        $conn = $db->getConnection();
        $email = $_SESSION['teacher_login'];
        $subject_code = $request->subject_code;
        $semester = $request->semester;
        $section_id = $request->section_id;
        //$section_id = 'A';
        //$semester = '5';
        //$subject_code = 'CS540';
        /*$query = "SELECT U.usn, U.name
                  FROM users U, subjects SUB
                  WHERE U.section_id=SUB.section_id
                        AND SUB.staff_id=(SELECT staff_id
                                          FROM staff
                                          where email='$email')
                        AND SUB.subject_code='$subject_code'
                        AND U.section_id='$section_id'
                        AND U.semester='$semester'";
        */
        //$query2=SELECT e.usn, u.name FROM `electives` e, users u where e.sub_code='CS742' and u.semester=7 and e.usn=u.usn and u.section_id='A'
        /*$query = "SELECT U.usn, U.name
                  FROM users U, subjects SUB 
                  WHERE (U.section_id=SUB.section_id 
                         AND SUB.staff_id='{$_SESSION['staff_id']}' 
                         AND SUB.subject_code NOT IN (SELECT DISTINCT sub_code FROM electives)
       					 AND SUB.subject_code='$subject_code'
                         AND U.section_id='$section_id' 
                         AND U.semester='$semester')
                  OR (U.usn IN (SELECT usn 
                                FROM electives 
                                WHERE electives.sub_code=SUB.subject_code
                 		              AND electives.sub_code='$subject_code')
                      AND U.semester='$semester'
                      AND U.section_id='$section_id'
                      AND U.section_id=SUB.section_id)";
        */
        $query = "SELECT t1.usn, t1.name, t2.cie
                  FROM (SELECT s.usn, s.name 
                        FROM student s inner JOIN subject sub ON (s.section_id=sub.section_id AND s.semester=sub.semester)
                        WHERE   
                        (sub.subject_code='CS110' AND sub.section_id='C')
                        AND
                        (
	                      (sub.subject_code NOT IN (SELECT DISTINCT subject_code from electives_taken))
	                      OR
	                      (s.usn IN (SELECT usn FROM electives_taken WHERE subject_code=sub.subject_code))
                        )) t1 LEFT OUTER JOIN marks t2 ON t1.usn=t2.usn";
        $data = [];
        if($res = $conn->query( $query)) {
            $i = 0;
            while($row = $res->fetch_assoc())   {
                $data[$i]['usn'] = $row['usn'];
                $data[$i]['name'] = $row['name'];
                $data[$i]['cie'] = $row['cie'];
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