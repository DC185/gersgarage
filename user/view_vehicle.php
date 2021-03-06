<?php
// Initialize the session
session_start();
 
// Include config file
require_once "includes/config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");  
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

  <nav class="navbar navbar-expand navbar-white  static-top">

  <a class="navbar-brand mr-1" href="index.html"><img src="../img/logoWhite.svg" alt="" title="" width="275" height="56" /></a>

    <a href="#body"></a>

    <button class="btn btn-link btn-sm text-dark order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

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
          <li class="breadcrumb-item active">View Vehicle</li>
        </ol>

        <div class="content">
        <div class="container-fluid">
            <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Registered Customer Vehicles</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                  <th>ID</th>
                    <th>Reg</th>
                    <th>Type</th>
                    <th>Make/Model</th>
                    <th>engine_type</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                  <th>ID</th>
                    <th>Reg</th>
                    <th>Type</th>
                    <th>Make/Model</th>
                    <th>engine_type</th>
                  </tr>
                </tfoot>
                <?php
                $tid=$_SESSION["id_customer"];
                $sql=mysqli_query($mysqli,"SELECT customer_vehicle.*, vehicle.* FROM customer_vehicle 
                INNER JOIN vehicle ON customer_vehicle.id_vehicle = vehicle.id_vehicle
                where id_customer=$tid");

                while ($row=mysqli_fetch_array($sql)) {
                ?>
                    <tbody>
                    <tr>
                        <td><?php  echo $row['id_cvehicle'];?></td>
                        <td><?php  echo $row['reg'];?></td>
                        <td><?php  echo $row['type'];?></td>
                        <td><?php  echo $row['make_model'];?></td>
                        <td><?php  echo $row['engine_type'];?></td>
                    </tr>
                    <?php 
                        $cnt=$cnt+1;
                    }?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>  



                    </div> <!-- container -->

                </div> <!-- content -->
                </div>
                </div>
      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
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
