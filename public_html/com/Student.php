<?php
require_once "Subject.php";


class Student   {
    var $name;
    var $max_co;
    var $subject;
    function __construct($name)
    {
        $this->name = $name;
        $this->max_co = array("CIE1"=> array(5,5,6,4,10), "CIE2"=> array(4,6,5,6,9), "CIE3"=> array(5,5,6,4,10),
            "CIE4"=> array(5,5,6,4,10), "CIE5"=> array(5,5,6,4,10));
        $this->subject = new Subject('CS540');
    }

    function get_name() {
        return $this->name;
    }

    function set_name($name)    {
        $this->name = $name;
    }

    function display_student()  {
        echo $this->name."<br>";
        foreach ($this->max_co as $cie) {
            foreach ($cie as $item) {
                echo $item." ";
            }
            echo "<br>";
        }
    }
}
