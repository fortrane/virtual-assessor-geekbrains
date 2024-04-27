<?php

@session_start();

require_once __DIR__ . "/src/Custom/Medoo/connect.php";
require_once __DIR__ . "/src/Functions/utility.class.php";
require_once __DIR__ . "/src/Controllers/Routes.php";
require_once __DIR__ . "/src/Controllers/Templates.php";

$routes = new Routes($database);
