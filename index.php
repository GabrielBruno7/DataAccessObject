<?php

require_once("Config/config.php");

$database = new Database;
$user = new User();

$user->login("larissa@gmail.com", "larissa123");
header('Location: views\home.html');
exit;


