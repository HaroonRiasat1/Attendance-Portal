<?php
$user='root';
$pass='';
$db='test';
$db=new mysqli('localhost',$user,$pass,$db) or die("Unable to Connect");

session_start();
$rollno= $_SESSION['rollno'];
/*echo "<h1>";
echo $rollno;
echo "</h1>";*/
error_reporting(0); 


$q="select First_Name,Last_Name from user where Roll_No='$rollno'";
$result=$db->query($q);
while($row=$result->fetch_assoc())
{
    $FNAME= $row["First_Name"];

    $LNAME= $row["Last_Name"];

}




$q="select attendance from persons P join user U where P.Roll_Num=U.Roll_No and U.Roll_No='$rollno' and P.date1=CURDATE()";
$result=$db->query($q);
while($row=$result->fetch_assoc())
{
    $attend= $row["attendance"];



}



?>
<html>

<head>
    <script src="https://kit.fontawesome.com/6d31fd2a34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
<style>
    .navbar{
        color:white;
    }
    .img1{
             border-radius: 50%;
             width:220px;
             height:200px;
    }
    .size{
        width:140px;
        
    }
    .name {
    text-align:center;
    padding:10px;
    }
        .center {
width:100%;
  margin-left: auto;
  margin-right: auto;

}
        body {
		background-color:whitesmoke;
	}
  .btn{
      margin-bottom:20px;
  }
 body{ 
  min-height: 100vh; 
  margin: 0; 
  
  display: grid;
  grid-template-rows: auto 1fr auto;
}

header{ 
  min-height:50px;
  background:lightcyan; 
}
.fab{
    margin:5px;    
}

footer{ 
  min-height:50px; 
  background:PapayaWhip; 
}
  
</style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Attendance Portal</a>
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    Logout

                </a>
            </li>
        </ul>
    </nav>


    <div class="container-fluid">
        <div class="row">


            <div class="col col-lg-2">
                <?php

                        $sql = "SELECT * FROM user WHERE Roll_No='$rollno'";
                        $sth = $db->query($sql);
                        $result=mysqli_fetch_array($sth);
                        echo '<img class="img1" src="data:image/jpeg;base64,'.base64_encode( $result['img'] ).'" alt="Image.txt"/>';


                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input class="btn size btn-sm" type="file" name="image" />
                    <input class="btn btn-sm" type="submit" name="submit" value="Upload" />
                </form>
            </div>
            <div class="col name">
                <h1>
                    Welcome <?php echo $FNAME;echo " ";echo $LNAME; ?>
                </h1>
                <br />
                <form action="" method="post" enctype="multipart/form-data">
                    <button name="ViewAttendance" class="btn btn-dark">View Attendance</button>

                    <?php
                    if($attend!='P' && $attend!='R' && $attend!='L' )
                    {
                    ?>

                    <button name="Mark" class="btn bg-primary">Mark Attendance</button>


                    <button name="leave" class="btn bg-warning">Request for leave</button>


                </form>


                <?php
                    }
                if($attend=='P')
                {

                   echo '<button name="" class="btn bg-success">Todays attendance has been Marked</button>';

                }

                 if($attend=='R')
                {
                ?>
                <button name="" class="btn bg-warning">Requested for Leave</button>
                <?php
                }

                 if($attend=='L')
                 {
                ?>
                <button name="" class="btn bg-success">Leave Approved</button>
                <?php
                 }



                if(isset($_POST["leave"]))
                {
                    $q="insert into persons(Roll_Num,attendance,date1) values('$rollno','R',sysdate())";
                    $result=$db->query($q);

                    if($result){
                        $status1 = 'success';
                        echo $status1;

                        header("refresh: 3;");

                    }

                }
                if(isset($_POST["Mark"]))
                {
                    $q="insert into persons(Roll_Num,attendance,date1) values('$rollno','P',sysdate())";
                    $result=$db->query($q);

                    if($result){
                        $status1 = 'success';
                        echo $status1;

                        header("refresh: 3;");

                    }


                }
                if(isset($_POST["ViewAttendance"]))
                {
                    $q="select date1,attendance from Persons where Roll_Num='$rollno'";
                    $result=$db->query($q);
                    echo "<table border='1' class='table-dark table-striped table-hover center'>

                            <tr>

                            <th>Date</th>

                            <th>Attendance</th>
                               </tr>";

                    while($row=$result->fetch_assoc())
                    {
                        echo "<tr>";

                        echo "<td>" . $row['date1'] . "</td>";

                        echo "<td>" . $row['attendance'] . "</td>";
                        echo "</tr>";

                    }
                    echo "</table>";
                }




                ?>

            </div>
        </div>
    </div>

    <?php

    $status = $statusMsg = '';
if(isset($_POST["submit"])){
    $status = 'error';
    if(!empty($_FILES["image"]["name"])) {
        // Get file info
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif');
        if(in_array($fileType, $allowTypes)){
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            // Insert image content into database
            $insert = $db->query("update user set img='$imgContent' where Roll_No='$rollno'");

            if($insert){
                $status = 'success';
                $statusMsg = "File uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            }
        }else{
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    }else{
        $statusMsg = 'Please select an image file to upload.';
    }
}

// Display status message
echo $statusMsg;

    ?>




    <footer class="text-center text-lg-start bg-light text-muted">
        <!-- Section: Social media -->
        <section
            class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <!-- Left -->
            <div class="me-5 d-none d-lg-block">
                <span>Get connected with us on social networks:</span>
            </div>
            <!-- Left -->

            <!-- Right -->
            <div>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-google"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-github"></i>
                </a>
            </div>
            </section>
    </footer>


</body>

</html>


