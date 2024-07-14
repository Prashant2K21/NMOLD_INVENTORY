<?php
session_start();
//remove the session variables
session_unset();
//destroy
session_destroy();
header("location: login.php");
?>