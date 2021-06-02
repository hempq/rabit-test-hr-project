<?php

class Advertisement
{
    // table fields
    public $id;
    public $title;
    public $user_id;
    // message string
    public $id_msg;
    public $title_msg;
    public $user_id_msg;
    // constructor set default value
    function __construct()
    {
        $id=0;$title="";$user_id=0;
        $id_msg=$title_msg="";
    }
}

?>