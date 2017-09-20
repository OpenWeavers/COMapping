<?php

/**
 * Created by PhpStorm.
 * User: vinyas
 * Date: 9/15/17
 * Time: 9:14 PM
 */
class CIE
{
    var $max_co;
    var $co_matrix;
    function __construct($max_co)
    {
        $this->max_co = $max_co;
        $this->co_matrix = array("CIE1" => array(), "CIE2" => array(),
            "CIE3" => array(),"CIE4" => array(),"CIE5" => array());
    }

    function set_co()   {
        foreach ($this->co_matrix as $key => $value)    {
                $this->co_matrix[$key][] = array(3, 3, 4, 5, 10, 5);
        }
    }
}