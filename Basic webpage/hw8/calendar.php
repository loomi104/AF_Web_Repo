<?php


session_start();
if(!$_SESSION['active'])
{
      header("Location: https://www-users.cselabs.umn.edu/~and03011/login.php");
      
}

//ini_set('display_errors','On');
//error_reporting(E_ALL);


$return = "";
$noEvents = "";
$valid = True;
$days=array('Monday','Tuesday','Wednesday','Thursday','Friday');
$userName= $_SESSION['userName'];
$scroll ="";

if($_POST['sb']=="Clear")
{
	file_put_contents('calendar.txt','');
	$noEvents .= "Calendar has no events. Please use the input page to enter some events.<br>";
}
else
{
if(!isset($_POST['event']) || empty($_POST['event']))
{
     $return .= "Please provide a value for Event Name<br>";
     $valid=False;
}

if(!isset($_POST['startTime']) || empty($_POST['startTime']))
{
     $return .= "Please provide a value for Start Time<br>";
     $valid=False;
}

if(!isset($_POST['endTime']) || empty($_POST['endTime']))
{
     $return .= "Please provide a value for End Time<br>";
     $valid=False;
}

if(!isset($_POST['loc']) || empty($_POST['loc']))
{
     $return .= "Please provide a value for Start Time<br>";
     $valid=False;
}

$file=file_get_contents('calendar.txt');



if($valid)
{
	if(!$file)
	{
		for($i=0;$i<count($days);$i++)
		{
			if($_POST['day']==$days[$i])
		     	{
				$jsonData[$days[$i]] =array(array("event"=>$_POST['event'],'start'=>$_POST['startTime'],'end'=>$_POST['endTime'],'place'=>$_POST['loc']));
			}
		     	else
		     	{
				$jsonData[$days[$i]] =array();
		     	}
		}
	}
	else
	{
		$noEvents = "";
		$jsonData = json_decode($file,true);
		for($i=0;$i<count($days);$i++)
		{
			$temp=$jsonData[$days[$i]];
			if(($_POST['day']==$days[$i]) && (empty($temp)))
			{     	
				$jsonData[$days[$i]] =array(array("event"=>$_POST['event'],'start'=>$_POST['startTime'],'end'=>$_POST['endTime'],'place'=>$_POST['loc']));
			}	
			elseif($_POST['day']==$days[$i])
	     		{
				array_push($jsonData[$days[$i]],(array("event"=>$_POST['event'],'start'=>$_POST['startTime'],'end'=>$_POST['endTime'],'place'=>$_POST['loc'])));
	     		}
		}
		
	}
	
	for($i=0;$i<count($days);$i++)
	{
		if(count($jsonData[$days[$i]])>1)
		{
			usort($jsonData[$days[$i]],function($time1,$time2){
				$hr1 = date("G",strtotime($time1['start']));
				$hr2 = date("G",strtotime($time2['start']));
				if($hr1==$hr2)
				{
					return 0;
				}
				elseif($hr1 < $hr2)
				{
					return -1;
				}
				else
				{
					return 1;
				}
			});
		}
	}
	
	echo "<br>";
	//$locArray = $jsonData[$_POST['day']];
	$json = json_encode($jsonData);
	file_put_contents('calendar.txt',$json);
	//echo $json;
	//$return = "Valid Request Entered";
	$locArray = array();
 	for($i=0;$i<count($days);$i++)
	{
		if(!empty($jsonData[$days[$i]]))
		{
		$scroll .= "   " . $days[$i];
			for($j=0;$j<count($jsonData[$days[$i]]);$j++)
			{
				array_push($locArray,$jsonData[$days[$i]][$j]['place']);
				$scroll .= "      Event: ". $jsonData[$days[$i]][$j]['event']." || ". $jsonData[$days[$i]][$j]['start'] . "- ". $jsonData[$days[$i]][$j]['end']." ||  Location: ". $jsonData[$days[$i]][$j]['place'];
			}
		}
	}
	$temp=json_encode($locArray);
	echo "<script type ='text/javascript'> var lArray=" . $temp . " </script>";
	echo '<script type ="text/javascript" src= "map.js"></script>';
	
}
}

?>

<!-- my api key:  AIzaSyDoF8nduTaC_wmLiq0UrYrLeOKRcB3N9iU 
                  AIzaSyDoF8nduTaC_wmLiq0UrYrLeOKRcB3N9iU-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset = "utf-8">
    <title>and03011 Calender</title>
  </head>
  <body>
     
    <div class="header">
      <h1>Kyle's Calender </h1>
      
      <div class="right">
        <?php echo "Hi $userName"; ?><br>
        <form action="logout.php">
      	  <input type="submit" value="Logout">
        </form>
      </div>
    </div>
    <nav>
      <form action="#">
	  <input type="submit" value="Calender">
      </form>
      <form action="input.php">
	  <input type="submit" value="Form Input">
      </form>
    </nav>
    <div class="missingFields"> <?php echo $noEvents; echo $return; ?></div><br>
    <div class="scroll">
      <?php echo $scroll; ?>
    </div>
    <br>
    <?php
	$file=file_get_contents('calendar.txt');
	$jsonData = json_decode($file,true);
	foreach($days as $day)
	{
		if(!empty($jsonData[$day]))
		{
			$tRow = '<table class ="calendar"><tr><th><span>' . $day . '</span></th>';			 for($i=0;$i<count($jsonData[$day]);$i++)
			{
				$tRow .= "<td>" . $jsonData[$day][$i]['event']."<br> ". $jsonData[$day][$i]['start'] . "-" . $jsonData[$day][$i]['end']."<br> ". $jsonData[$day][$i]['place'] . "</td>";
			}
			$tRow .= "</tr></table>";
			echo $tRow;

		}	
	}
    ?>
    
    
    <div id="map"></div>  
    <br><br>
    <p> The browser used to test this calender was Firefox  </p>
    <br>
    <script type ="text/javascript" src="map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoF8nduTaC_wmLiq0UrYrLeOKRcB3N9iU&libraries=places,geometry&callback=initMap" async defer></script>
    <!--<script type ="text/javascript" src="scroll.js"></script>
    -->
  </body>
</html>