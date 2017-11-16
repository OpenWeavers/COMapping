<?php
session_start();
if(!isset($_SESSION['teacher_login']))   {
    header('location:../../');
}

require '../../com/config/DBHelper.php';

$db = new DBHelper();
$conn = $db->getConnection();
$email = $_SESSION['teacher_login'];
$staff_id = $_SESSION['staff_id'];

$query = "SELECT s.subject_code, s.subject_name, s.section_id
FROM subject_teachers AS st INNER JOIN subject AS s
ON (st.subject_code=s.subject_code AND st.section_id=s.section_id)
WHERE st.staff_id='$staff_id'";

$data = [];
if($res = $conn->query($query)) {
    $i = 0;
    while($row = $res->fetch_assoc())   {
        $data[$i]['subject_code'] = $row['subject_code'];
        $data[$i]['subject_name'] = $row['subject_name'];
        $data[$i]['section_id'] = $row['section_id'];
        $i++;
    }
    $num_of_subjects = $i;

    for($i = 0; $i < $num_of_subjects; $i++)  {
        $subject_code = $data[$i]['subject_code'];
        $section_id = $data[$i]['section_id'];
        $query = "SELECT count(t1.usn) as total_students, count(t2.cie) as total_entered, (case when t1.max_co IS NULL THEN 0 ELSE 1 END) as cie_entered
                  FROM (SELECT s.usn, sub.max_co 
                        FROM student s inner JOIN subject sub ON (s.section_id=sub.section_id AND s.semester=sub.semester)
                        WHERE   
                        (sub.subject_code='$subject_code' AND sub.section_id='$section_id')
                        AND
                        (
	                      (sub.subject_code NOT IN (SELECT DISTINCT subject_code from electives_taken))
	                      OR
	                      (s.usn IN (SELECT usn FROM electives_taken WHERE subject_code=sub.subject_code))
                        )) t1 LEFT OUTER JOIN marks t2 ON t1.usn=t2.usn";

        if($res = $conn->query($query)) {
            $row = $res->fetch_assoc();
            $data[$i]['total_students'] = $row['total_students'];
            $data[$i]['total_entered'] = $row['total_entered'];
            $data[$i]['cie_entered'] = $row['cie_entered'];
        }
    }

    echo json_encode(array("success" => true, "data" => json_encode($data)));
}
else    {
    echo json_encode(array("success" => false,"data" => "Nothing"));
}
$db->closeConnection($conn);