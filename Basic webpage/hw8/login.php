<?php

//ini_set('display_errors','On');
//error_reporting(E_ALL);

session_start();

$invalidUser="";
$invalidPW="";
$noUsers="";
//$userName="";
$createSession=True;
if($_POST['lsb']=="Submit"){
      if(!isset($_POST['user']) || empty($_POST['user']))
      {
            $invalidUser .= "Please enter a valid value for User Login Field.";
     	    $createSession=False;
      }

      if(!isset($_POST['pw']) || empty($_POST['pw']))
      {
            $invalidPW .= "Invalid Password: Please check your password and ensure it is correct.";
	    $createSession=False;
      }
      if($createSession){
	    $_SESSION['active']=False;
            $_SESSION['user']=$_POST['user'];
	    $_SESSION['pw']=$_POST['pw'];
	    $connection = new mysqli('egon.cs.umn.edu','C4131F16U5',2247,'C4131F16U5',3307);
	    if($connection->connect_error)
	    {
	          echo  die("<!DOCTYPE html><html><body>Could not connect to database </body></html>" );
            }
	    else{
		  $select = "acc_name, acc_login, acc_password";
		  $query = "SELECT " . $select . " FROM tbl_accounts";
		  $userInfo = $connection->query($query);
		  if($userInfo->num_rows>0){
		       while($row = $userInfo->fetch_assoc()){
		             if($_SESSION['user']==$row['acc_login'] && sha1($_SESSION['pw'])==$row['acc_password'])
			     {
				   $_SESSION['userName']=$row['acc_name'];
				   $_SESSION['active']=True;
			           header("Location: https://www-users.cselabs.umn.edu/~and03011/calendar.php");
			     }
			     else
			     {
			           $invalidUser = "Invalid Username or Password please check both and try again.";
				   
			     }
		       }
		  }
		  else
		  {
		        $noUsers="There are no users permitted access to this page";	        
		  }
	    }
	    
      }
      
}
?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset = "utf-8">
    <title>LOGIN: and03011</title>
</head>


<body>
<div class="header">
  <h1>Login Page</h1>
</div>
<br>
<div class="missingFields"> <?php echo $noUsers;?></div>
<div class="missingFields"> <?php echo $invalidUser;?></div><br>
<div class="missingFields"> <?php echo $invalidPW; ?></div><br>

<div class="formbox">
  <form action="http://www-users.cselabs.umn.edu/~and03011/login.php" method="post" >
    User Name:<br>
    <input type="text" name="user"> <br>

    Password:<br>
    <input type="password" name="pw"> <br>
	
    <br><br>
    <input type="submit" name="lsb" value="Submit">
    
  </form>
</div>
</body>



</html>