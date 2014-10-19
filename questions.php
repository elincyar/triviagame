<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Trivia Game</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
		
	<link rel="stylesheet" href="triviastyles.css" type="text/css">
	
	<?php
include("dbconnect.inc.php");
//select the database to read from
mysql_select_db("trivia_game", $connectID)
  or die ("Unable to select database");
  
?>
</head>

<body>


<?php
 include('pageintro.inc.php');
 
if($_POST['submitsingle']){
	insertsq();
	//getlast();
	//testall();
}//end if question is entered

if($_POST['submitmulti']){
 insertmq();
 //getlast();
 //testall();
}


function insertsq(){
global $connectID;

$myErrors = array();

$question =$_POST['question'];
if($question==""){
	$myErrors[] .= "please enter a question";

}
	//echo $question;
	$answer = $_POST['answer'];
	if($answer==""){
	$myErrors[] .= "please enter a answer";
	
}
	//echo $answer;
	$catID = $_POST['category'];
	if($catID=="100"){
	$myErrors[] .= "please select a category";
	
}
	echo $catID;
if(count($myErrors)>0){
echo "<p class='warning' >";
	foreach($myErrors as $val){
	 echo $val."<br />";
	}
	echo "</p>";
	return;
}else{

	// write to database
	mysql_query("INSERT into questions (question, answer, catID) 
			     VALUES ('".$question."', '".$answer."', '".$catID."')", $connectID)   
			    or die ("Unable to insert record into database");
			    
			    echo "you just inserted-<br/> Question:".$question." <br /> Answer:".$answer."<br /> catID of ".$catID."";
			    $question="";
			    $answer="";
			    
			    }
			    
}//end insertsq


function insertmq(){
	global $connectID;
	
	$all = $_POST['multi'];
	
	$catID= $_POST['category'];
	
	
$seperated_lines = explode("\n",$all);
$i = 0;
foreach($seperated_lines as $qa) {
if($qa!=null){
 $break_line = explode("/",$qa);
 $question_array[++$i]['question'] = $break_line[0];
 $question_array[$i]['answer'] = $break_line[1];
 
 }
}

foreach($question_array as $qa) {
		// write to database
	mysql_query("INSERT into questions (question, answer, catID) 
			     VALUES ('".$qa['question']."', '".$qa['answer']."', '".$catID."')", $connectID)   
			    or die ("Unable to insert record into database");
			    }
			   
	
	
}//end multiinsert

function createOptions(){
global $connectID;
$output="";
$catSelectOptions = mysql_query("SELECT * from categories", $connectID)
or die("unable to select-catoptions"); 

		while ($row = mysql_fetch_array($catSelectOptions)) {
			
    			$output.= "<option value='".$row['cID']."'> ". $row['category']."</option>\n";
    			
    			}
    			
    			return $output;
		
}

?>
    
<div id="leftsingle">
<p>Enter questions one at a time</p>
<form id="singleqs" method="post" action="<?php $_SERVER['PHP_SELF'] ?>" >
	Question	<input type="text" id="question" name="question" value="<?php echo $question; ?>" ><br />
	Answer	<input type="text" id="answer" name="answer" value="<?php echo $answer; ?>"><br />
<select id="category" name="category">
		<option value="100">SELECT</option>
		<?php 
			echo createOptions();		
		?>
			</select>

	<input type="submit" name="submitsingle" value="Enter">
	</form>
			
</div>
<div id="rightmulti">
<form id="multiqs" method="post" action="<?php $_SERVER['PHP_SELF'] ?>" >
<p>Enter multiple questions that have the same category</p>
<textarea cols="80" rows="25" name="multi"></textarea><br />
<select id="category" name="category">
		<option value="100">SELECT</option>
		<?php 
		echo createOptions();
		?>
		</select>

	<input type="submit" name="submitmulti" value="Enter">
	</form>
</div>
	<div style="clear:all;">
	<?php
	function testall(){
	global $connectID;
	
	//read from database
	$myDataID = mysql_query("SELECT * from questions", $connectID);
	print "<table border='1'>";
	while ($row = mysql_fetch_row($myDataID)) {
	print "<tr>";
	foreach ($row as $field) {
				print "<td> ". $field."</td>";
				}//end foreach
	print "</tr>";
	}//end while
	print "</table>";
	
	return;
	}
	?>

</div><!-- end test div-->
<?php
	include("footer.inc.php");
	?>
</body>
</html>