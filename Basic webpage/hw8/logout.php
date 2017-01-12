<?php


ini_set('display_errors','On');
error_reporting(E_ALL);
session_start();
unset($_SESSION['user']);
unset($_SESSION['pw']);
session_destroy();
 

$html=
'<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset = "utf-8">
    <title>LOGIN: and03011</title>
</head>


<body>
<div class="header">
  <h1>Logout Page</h1>
</div>
<br>



<div class="formbox">
  <h2> You have logged out. You will be redirected to the login page shortly </h2>
</div>
</body>
</html>';
echo $html;
header("refresh:5; url=https://www-users.cselabs.umn.edu/~and03011/login.php");
?>
