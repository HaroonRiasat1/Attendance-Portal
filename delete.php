<?php
$user='root';
$pass='';
$db='test';
$db=new mysqli('localhost',$user,$pass,$db) or die("Unable to Connect");

$id = $_GET['id']; // get id through query string
$date = $_GET['date'];

$del = mysqli_query($db,"delete from persons where Roll_Num = '$id' and date1='$date'"); // delete query

if($del)
{
    mysqli_close($db); // Close connection
    header("location:adminportal.php"); // redirects to all records page
    exit;	
}
else
{
    echo "Error deleting record"; // display error message if not delete
}



?>