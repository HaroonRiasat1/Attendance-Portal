<html>

<head>
	<script src="https://kit.fontawesome.com/6d31fd2a34.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
		@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap');
	body {
		background-color:whitesmoke;
	}
h2{

	text-align:center;
}
.bt1{
	text-align: center;
	margin-left: 1050px;
	
}
	@media (min-width:1020px) {
		.alert {
			bottom: 100px;
			width: 400px;
			left: 980px;
			text-align: center;
		}
	}
	
h2:hover{
	color: #ff00dc;
}
	.firstpage {
		background-color:whitesmoke;
	}

	.picture {
		position:relative;
		
		

	
	}
	img {
			padding-top:10px;
			height:750px;
		width:800px;
			border-radius: 50px;

	}
	.loginbutton {
				text-align:center;
			top:100px;
			font-family: 'Montserrat-Bold', sans-serif;
	}
	.login-form{
		padding:120px;
		
	}
	.input-group {
		padding:10px;
			
	}
	#roll {
		border-radius: 50px;
			height:50px;
	}
	#password {
		border-radius: 50px;
		height:50px;
	}
	.btn {
			border-radius: 50px;
	}
	
</style>
</head>

<body>

<div class="container-fluid firstpage">

	<div class="row">
<div class="col picture">
	<img src="login.jpg" />
</div>
	<div class="col loginbutton">
		<h1>Login</h1>
		Login to Mark your Attendance.

	<form class="login-form" method="post">
		<h3>Please Enter Your Credentials.</h3>
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fas id1 fa-id-card-alt"></i>
			</span>
			<input id="roll" type="text" class="form-control" name="rollno" placeholder="RollNo" />
		</div>
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fas fa-key"></i>
			</span>
			<input id="password" type="password" class="form-control" name="password" placeholder="Password" />
		</div>
		<input type="submit" id="button" class="btn btn-outline-dark btn-lg" value="Login" name="login" />
	</form>



        For Registeration:
        <a href="registrationpage.php">click here</a>
	</div>
        
		</div>

</div>


	

</body>






<?php
$user='root';
$pass='';
$db='test';
$db=new mysqli('localhost',$user,$pass,$db) or die("Unable to Connect");

/*

$q="select First_Name,Last_Name from user";
$result=$db->query($q);
while($row=$result->fetch_assoc())
{
echo "<h2>";
echo $row["First_Name"];
echo "&nbsp";
echo $row["Last_Name"];
echo "</h2>";




}
*/


if(isset($_POST["login"]))
{

	$roll=$_POST['rollno'];
	$password=$_POST['password'];

	if($roll=='admin' and $password='admin')
		{
        	header("Location:adminportal.php");
            exit();

    }


	error_reporting(0);

	$q="select First_Name,Last_Name from user where Roll_No='$roll' and Password='$password'";
	$result=$db->query($q);
	while($row=$result->fetch_assoc())
	{

		$FNAME= $row["First_Name"];





	}


	if(is_null($FNAME))
	{
	echo "<div class='alert alert-danger' role='alert'>";
   echo "Login Unsuccessful! Wrong Credentials";
   echo "</div>";
	}
	else{
		echo "Login Successfull";

        session_start();

        echo 'Welcome to page #1';

        $_SESSION['rollno'] = $roll;


        // Works if session cookie was accepted
        echo '<br /><a href="firstpage.php">page 2</a>';


        header("Location:firstpage.php");
        exit();

	}



}



?>
</html>
