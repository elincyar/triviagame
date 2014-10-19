<?php
//login page
$backpage = $_GET['page'];
echo $backpage;
 if($_POST['logIn']){
  check($_POST['uname'],$_POST['password']);
 }
 
 function check($u, $p){
$pFile = fopen('lala.txt', "r+");
 
$pArray= Array();
 //put into array
 if ($pFile) { //if it opened

		while (!feof($pFile)) { // as long we have not found the end of the file, repeatedly...
		$thisLine= fgets($pFile, 500); // get the next line of the file,
		//echo $thisLine. '<br/>'; // uncomment to write out the lines for testing
		$pArray[]= explode(",", $thisLine); // move  delimited elements of the line into array elements
		
		}//end while
		
		foreach($pArray as $line){
		if($line[0]==$u){
			if($line[1]==$p){
		
				setcookie("authenticate", $u);
				header("location:".$backpage."");
			}else{
				echo " invalid password for username";
			}
		}	
		}
		
	
}//end if

fclose($File); // we're done -close the file 
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Trivia Game- Login</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	
	<link rel="stylesheet" href="triviastyles.css" type="text/css">
</head>
<?php 
include("dbconnect.inc.php");

//select the database to read from
mysql_select_db("trivia_game", $connectID)
  or die ("Unable to select database");
  
  
?>
<body>
<?php
 include('pageintro.inc.php');
	?>
 <h2>Please Login to Continue </h2>
<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" >
<input type="text" name="uname"  />
<input type="password" name="password"  />
<input type="submit" name="logIn" value="Log In" />
</form>

<?php
 	

 include('footer.inc.php');
?>

</body>
</html>