<?php

$hostURL = "localhost";
$userName = "root";
$password = "";

// connect to database
$connectID = mysql_connect($hostURL, $userName, $password)
  or die ("Sorry, can't connect to database");

