<?php


session_start();
if(!$_SESSION['active'])
{
      header("Location: https://www-users.cselabs.umn.edu/~and03011/login.php");
      
}
//ini_set('display_errors','On');
//error_reporting(E_ALL);

$userName= $_SESSION['userName'];
//$scroll ="Hi $userName";


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset = "utf-8">
    <title>Calendar Input</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    
</head>

<body>
<div class="header">
  <h1>Calender Input</h1>
  <div class="right">
        <?php echo "Hi $userName";?>
	<form action="logout.php">
      	  <input type="submit" value="Logout">
        </form>
  </div>
</div>
<nav>
  <form action="calendar.php">
    <input type="submit" value="Calender">
  </form>
  <form action="#">
    <input type="submit" value="Form Input">
  </form>
</nav>
<div class="scroll">
      <p></p>
</div>

<div class="formbox">
  <form action="http://www-users.cselabs.umn.edu/~and03011/calendar.php" method="post" >
    Event Name:<br>
    <input type="text" name="event"> <br>

    Start Time:<br>
    <input type="time" name="startTime"> <br>
	
    End Time:<br>
    
    <input type="time" name="endTime"> <br>
	
    Location:<br>
    <input type="text" name="loc"> <br>
	
    <br>
    Day Of Week:<br>
      <select name="day">
	<option value="Monday">Monday</option>
	<option value="Tuesday">Tuesday</option>
	<option value="Wednesday">Wednesday</option>
	<option value="Thursday">Thursday</option>
	<option value="Friday">Friday</option>
      </select>
    <br><br>
    <input type="submit" name="sb" value="Submit">
    <input type="submit" name="sb" value="Clear">
  </form>
</div>
</body>
</html>
