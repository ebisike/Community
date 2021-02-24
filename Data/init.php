<?php

ob_start();
session_start();

require_once ('DB.php');

require_once $_SERVER['DOCUMENT_ROOT'].'/Communit/Application/Function.php';

require_once 'TableConfiguration.php';

$dbTables = new TableConfiguration();