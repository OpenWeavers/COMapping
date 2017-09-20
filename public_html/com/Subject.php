<?php
require_once 'CIE.php';
class Subject
{
    var $subcode;
    var $co_attained;
    function __construct($subcode)
    {
        $this->subcode = $subcode;
        $this->co_attained = new CIE(6);
        $this->co_attained->set_co();
    }
}