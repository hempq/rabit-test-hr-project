<?php

class User
{
    // table fields
    public $id;
    public $name;
    // message string
    public $id_msg;
    public $name_msg;
    // constructor set default value
    function __construct()
    {
        $id=0;$name="";
        $id_msg=$name_msg="";
    }
}

?>