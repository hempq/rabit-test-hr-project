<?php
session_unset();
require_once 'controller/AdvertisementController.php';
$controller = new AdvertisementController();
$controller->mvcHandler();
?>