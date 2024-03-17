<?php

require_once("Config/config.php");

$database = new Database;
$user = new User();

echo json_encode($user->login("sarah_miller", "senha123"));

echo json_encode($user->getEmail());