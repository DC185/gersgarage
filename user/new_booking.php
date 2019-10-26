<?php
// Initialize the session
session_start();
 
// Include config file
require_once "includes/config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");

}

else
{
    if(isset($_POST['submit']))
    {
        
        $uid=$_SESSION["id_customer"];
        $idcvehicle=$_POST['id_cvehicle'];
        $status="Booked";
        $date=$_POST['date'];
        $time=$_POST['time'];
        $comments=$_POST['comments'];
        $type=$_POST['service_type'];
        
        if(date('w', strtotime($date)) == 0) {
          $msg="Please select another date. Cannot make bookings on a sunday.";
          
        }
        else
        {
          
          $sql=mysqli_query($mysqli,"INSERT into service(id_customer,id_cvehicle,service_type,status,date,time,comments) value('$uid','$idcvehicle','$type','$status','$date','$time','$comments')");
          if ($sql) 
          {
          $msg="Data has been added successfully.";
          }
          else
          {
          $msg="Something Went Wrong. Please try again";
          }
        }
        
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Customer - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark  static-top">

    <a class="navbar-brand mr-1" href="index.html"><img src="../img/logoWhite.svg" alt="" title="" width="275" height="56" /></a>

    <a href="#body"></a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    

    <!-- Navbar -->

    

    <ul class="navbar-nav ml-auto ml-md-12">
    <li>
    <p class="logout">
    <?php
               $tid=$_SESSION["id_customer"];
               $sql = "SELECT name FROM customer Where id_customer = $tid";
               $result = $mysqli->query($sql);
               
             $row = $result->fetch_assoc();
                    echo "Logged in: " . $row["name"].  "<br>";
                
            ?>
   </p>
</li>
   <li>
   <button type="button" class="btn btn-primary" href="#" data-toggle="modal" data-target="#logoutModal">Sign Out</button>
</li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="welcome.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="new_booking.php">
          <i class="fas fa-fw fa-folder"></i>
          <span>New Booking</span></a>   
      </li>
      <li class="nav-item">
        <a class="nav-link" href="service_history.php">
          <i class="fas fa-fw fa-folder"></i>
          <span>Service History</span></a>   
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register_vehicle.php">
          <i class="fas fa-fw fa-folder"></i>
          <span>Register Vehicle</span></a>  
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view_vehicle.php">
          <i class="fas fa-fw fa-folder"></i>
          <span>View Vehicle</span></a>  
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Customer Dashboard</a>
          </li>
          <li class="breadcrumb-item active">New Booking</li>
        </ol>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title">Service Booking Form</h4>
                                <p class="text-muted m-b-30 font-14"></p>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <p style="font-size:16px; color:red" align="center"> <?php if($msg){echo $msg;}  ?> </p>
                                                    <form class="form-horizontal" role="form" method="post" name="submit">
                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label">Select Vehicle</label>
                                                        <div class="col-10">
                                                        <select name="id_cvehicle" id="id_cvehicle" class="form-control" required="true">
                                                                <option value="">Select Vehicle</option>
                                                              
                                                                    <?php 
                                                                    $uid=$_SESSION["id_customer"];
                                                                    $query=mysqli_query($mysqli,"SELECT customer_vehicle.*, vehicle.* FROM customer_vehicle 
                                                                    INNER JOIN vehicle ON customer_vehicle.id_vehicle = vehicle.id_vehicle
                                                                    where id_customer=$tid");
                                                                        
                                                                    while($row=mysqli_fetch_array($query))
                                                                            {
                                                                             ?>    
                                                                                <option value="<?php echo $row['id_cvehicle'];?>"><?php echo $row['reg']."\t-\t". $row['type']."\t-\t". $row['make_model']."\t-\t". $row['engine_type'];?></option>
                                                                            <?php } ?>  
                                                    </select>
                                                        </div>
                                                    </div>
 
                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Service Type</label>
                                                        <div class="col-10">
                                                            <select class="form-control" id="service_type" name="service_type" placeholder="Service Type">
                                                                <option>Annual Service</option>
                                                                <option>Major Service</option>
                                                                <option>Repair / Fault</option>
                                                                <option>Major Repair</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Time</label>
                                                        <div class="col-10">
                                                            <select class="form-control" id="time" name="time" placeholder="time">
                                                                <option>08:00</option>
                                                                <option>09:00</option>
                                                                <option>10:00</option>
                                                                <option>11:00</option>
                                                                <option>12:00</option>
                                                                <option>13:00</option>
                                                                <option>14:00</option>
                                                                <option>15:00</option>
                                                                <option>16:00</option>
                        
                                                            </select>
                                                        </div>
                                                    </div>
 
                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label">Date</label>
                                                        <div class="col-10">
                                                            <input type="date" class="form-control" name="date" id="date" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label">Comments</label>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" placeholder="comments" name="comments" id="comments">
                                                        </div>
                                                    </div>
                                                   

                                                     <div class="form-group row">
                                                    
                                                        <div class="col-12">
                                                           <p style="text-align: center;">  <button type="submit" name="submit" class="btn btn-primary btn-min-width mr-1 mb-1">Make New Booking</button></p>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card-box -->
                            </div><!-- end col -->
                        </div>     

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Gers Garage 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

</body>

</html>
