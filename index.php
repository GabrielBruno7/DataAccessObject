<?php

require_once("Config/config.php");

$database = new Database;
$user = new User("Gabriel", "Gabriel.bruno@gmail.com", "awvav2k");

$showUser = $user->getUser();

$usuarios = $database->select("SELECT * FROM users ");



echo json_encode($user->loadUserById(8));