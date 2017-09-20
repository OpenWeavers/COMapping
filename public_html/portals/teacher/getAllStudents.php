<?php
/**
 * Created by PhpStorm.
 * User: vinyas
 * Date: 9/17/17
 * Time: 4:30 PM
 */
require 'com/config/DBHelper.php';

$db = new DBHelper();
$conn = $db->getConnection();
$query = "select * from students";
if($res = mysqli_query($conn, $query))
{
    $count = mysqli_num_rows($res);

    $cr = 0;
    while($row = mysqli_fetch_assoc($res))
    {
        $data[$cr]['name']  = $row['name'];
        $data[$cr]['cie'] = $row['cie'];
        $cr++;
    }
}
echo json_encode($data);