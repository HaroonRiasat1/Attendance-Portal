<?php

$user='root';
$pass='';
$db='test';
$db=new mysqli('localhost',$user,$pass,$db) or die("Unable to Connect");

$id = $_GET['id'];// get id through query string
$date = $_GET['date']; // get id through query string


$qry = mysqli_query($db,"select * from persons where Roll_Num='$id' and date1='$date'"); // select query

$data = mysqli_fetch_array($qry); // fetch data

if(isset($_POST['update'])) // when click on Update button
{
    $Date = $_POST['date'];
    $attendance = $_POST['attend'];

    $edit = mysqli_query($db,"update persons set date1='$Date', attendance='$attendance' where Roll_Num='$id' and date1='$date'");

    if($edit)
    {
        mysqli_close($db); // Close connection
        header("location:adminportal.php"); // redirects to all records page
        exit;
    }
    else
    {
        echo mysqli_error();
    }
}
?>

<h3>Update Data</h3>

<form method="POST">
  <input type="date" name="date" value="<?php echo $data['date1'] ?>" placeholder="Date" Required>
  <input type="text" name="attend" value="<?php echo $data['attendance'] ?>" placeholder="Enter attendance" Required>
  <input type="submit" name="update" value="Update">
</form>