<?php
include_once 'functions/controller.php';
include_once 'view/parts/header.php';
$controller = new Controller();
$controller->routeRequest();
include_once 'view/parts/footer.php';
?>