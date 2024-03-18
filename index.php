<?php

require_once("Config/config.php");

$database = new Database;
$user = new User();

$user->updateUser(1, "vitor2ia10@gmail.com");

