<?php
require_once 'CIE.php';
/**
 * Created by PhpStorm.
 * User: vinyas
 * Date: 9/15/17
 * Time: 9:12 PM
 */
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