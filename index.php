<?php

require_once("config.php");

$database = new Database;

$usuarios = $database->select("SELECT * FROM users ");

echo json_encode($usuarios);