<?php
$user='root';
$pass='';
$db='test';
$db=new mysqli('localhost',$user,$pass,$db) or die("Unable to Connect");


/*echo "<h1>";
echo $rollno;
echo "</h1>";*/
 










?>
<html>

<head>
    <script src="https://kit.fontawesome.com/6d31fd2a34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
<style>
    .studentdata{
        text-align:left;
    }
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
 .btn1{
         margin:auto;
  display:block;
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
        <a class="navbar-brand" href="#">Admin Portal</a>
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


            
            <div class="col name">
                <h1>
                    Welcome Admin
                </h1>
                <br />
                <form action="" method="post" enctype="multipart/form-data">
                    <button name="ViewRecord" class="btn btn-dark">View Record</button>

                   

                   

                    <button name="check" class="btn bg-warning">Check Report</button>


                </form>


                <?php

                if(isset($_POST["check"]))
                {
                ?>
                     <form method="POST">
            From:
            <input type="date" name="date" placeholder="Date" required />
            To:
            <input type="date" name="date1" placeholder="End Date" required />
            <input type="submit" name="date2" value="Check" />
           
        </form>
                <?php
                    
                }



                if(isset($_POST['date2'])) // when click on Update button
                {
                    $sdate=$_POST['date'];
                    $edate=$_POST['date1'];


                    //"SELECT * FROM persons WHERE Roll_Num='$id' and date1 BETWEEN '$sdate' AND '$edate'"


                    $q="SELECT * FROM persons WHERE date1 BETWEEN '$sdate' AND '$edate'";
                    $result=$db->query($q);
                    echo "<table border='1' class='table-dark table-striped table-hover center'>

                            <tr>

                            <th>Roll Number</th>

                            <th>Date</th>
                            <th>Attendance</th>
                           



                               </tr>";


                    while($row=$result->fetch_assoc())
                    {
                        echo '<tr>';
                        echo '<td>';
                        echo $row['Roll_Num'];
                         echo '</td>';
                        echo '<td>';
                        echo $row['date1'];
                        echo '</td>';

                         echo '<td>';
                        echo $row['attendance'];
                           echo '</td>';
                           echo '</tr>';    
                    }



                }



                if(isset($_POST["ViewRecord"])){

                    $q="select * from user";
                    $result=$db->query($q);
                    while($row=$result->fetch_assoc())
                    {
                        echo '<div class="studentdata">';
                        echo '<h3>Student Details:</h3> ';
                        $roll=$row["Roll_No"];

                        echo $roll;
                        echo " ";
                        echo $row["First_Name"];
                        echo " ";
                        echo $row["Last_Name"];
                        echo '</div>';

                       

                        $leave=0;
                        $present=0;

                        $q1="select date1,attendance from Persons where Roll_Num='$roll'";
                        $result1=$db->query($q1);
                        echo "<table border='1' class='table-dark table-striped table-hover center'>

                            <tr>

                            <th>Date</th>

                            <th>Attendance</th>
                            <th>Delete</th>
                            <th>Edit</th>
                            <th>Leave</th>



                               </tr>";

                        while($row1=$result1->fetch_assoc())
                        {
                            echo "<tr>";

                            echo "<td>" . $row1['date1'] . "</td>";
                            $attend=$row1['attendance'];
                            echo "<td>" . $row1['attendance'] . "</td>";
                ?>
                         
                               <td>
                                   <a href="delete.php?id=<?php echo $roll; ?> & date=<?php echo $row1['date1']; ?>">Delete</a></td>
                <td>
                    <a href="edit.php?id=<?php echo $roll; ?> & date=<?php echo $row1['date1']; ?>">Edit</a>
                </td>

                <?php

                   if($attend=='R')
                   {
                        ?>
                   <td>
                    <a href="leave.php?id=<?php echo $roll; ?> & date=<?php echo $row1['date1']; ?>">Approve Leave</a>
                </td> 
                <?php
                   }


                          echo "</tr>";
                 if($attend=='L')
                 {
                     $leave=$leave+1;
                 }
                 if($attend=='P')
                 {
                     $present=$present+1;   
                 }
                 if($present<=10)
                 {
                     $grade='F';
                 }
                 elseif($present<=15)
                 {
                     $grade='D';
                 }
                 elseif($present<=20)
                 {
                     $grade='C';
                 }
                 elseif($present<=25)
                 {
                     $grade='B';
                 }
                 elseif($present>=26)
                 {
                     $grade='D';
                 }


                        }
                        echo "</table>";


                        echo 'Total Presents: ';
                        echo $present;
                        echo " ";
                        echo 'Total Leaves: ';
                        echo $leave;
                        echo " ";
                        echo 'Grade: ';
                        echo $grade;


                        echo '</br>';
                        echo  ' <button name="new" class="btn btn-dark">'; ?>
                        <a href="add.php?id=<?php echo $roll; ?>">Add More</a></button>
                <?php


                        echo  ' <button name="report" class="btn btn-dark">'; ?>
                        <a href="report.php?id=<?php echo $roll; ?>">CreateReport</a></button>
                <?php

                    }





                }



                ?>




              

            </div>
        </div>
    </div>

   




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


