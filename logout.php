<?php
include "config.php";

session_unset();   
session_destroy();

header("Location: public/login.php");
exit;
?>