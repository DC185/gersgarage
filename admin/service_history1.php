<?php
// Initialize the session
session_start();
 
// Include config file
require_once "includes/config.php";


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");

}

else{

 
}

if(isset($_POST['submit_date']))
{
    
    $status=$_POST['select_date'];

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

  <title>Admin - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark  static-top">

    <a class="navbar-brand mr-1" href="index.html"><img src="../img/logoWhite.svg" alt="" title="" /></a>

    <a href="#body"></a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    

    <!-- Navbar -->

    <ul class="navbar-nav ml-auto ml-md-12">
    <li>
    <p class="logout">
    <?php
               $tid=$_SESSION["id_admin"];
               $sql = "SELECT name FROM admin Where id_admin = $tid";
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
        <a class="nav-link" href="customers.php">
          <i class="fas fa-fw fa-folder"></i>
          <span>Customers</span></a>   
      </li>
      <li class="nav-item">
        <a class="nav-link" href="service_history.php">
          <i class="fas fa-fw fa-folder"></i>
          <span>Service History</span></a>   
      </li>
      <li class="nav-item">
        <a class="nav-link" href="mechanics.php">
          <i class="fas fa-fw fa-folder"></i>
          <span>Mechanics</span></a>  
      </li>
      <li class="nav-item">
        <a class="nav-link" href="parts.php">
          <i class="fas fa-fw fa-folder"></i>
          <span>Parts</span></a>  
      </li>
    </ul>

    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Admin Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Service History</li>
        </ol>

        <div class="content">
        <div class="container-fluid">
        <form class="form-horizontal" role="form" method="post" name="submit_date">
           <div class="form-group">

              <div class="form-group row">
                  <label class="col-2 col-form-label">Vehicle Registration</label>
                   <div class="col-10">

                   <a href="edit_service.php?sid=<?php echo $row['id_service'];?>"><p class="fa fa-edit"></p></a>
                    <input type="date" class="form-control" placeholder="Vehicle Registration" name="delect_date" id="select_date">
                   </div>
                </div>

           

               <div class="form-group row">
                                                    
                 <div class="col-12">
                  <p style="text-align: center;">  <button type="submit" name="submit_date" class="btn btn-primary btn-min-width mr-1 mb-1">Print Schedule</button></p>
                  <button type="submit" name="submit" class="btn btn-primary btn-min-width mr-1 mb-1">Register Vehicle</button>
                </div>
                </div>

            </form>
           </div>
          </div>
          </div>


      <div class="container-fluid">
            <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Service History</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                  <th>ID</th>
                  <th>Cust ID</th>
                    <th>Reg</th>
                    <th>Type</th>
                    <th>Make/Model</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Service Type</th>
                    <th>Status</th>
                    <th>Mechanic</th>
                    <th>Update</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                  <th>ID</th>
                  <th>Cust ID</th>
                    <th>Reg</th>
                    <th>Type</th>
                    <th>Make/Model</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Service Type</th>
                    <th>Status</th>
                    <th>Mechanic</th>
                    <th>Update</th>
                  </tr>
                </tfoot>
                <?php
                $sql=mysqli_query($mysqli,"SELECT service.*, customer_vehicle.*, vehicle.*, mechanic.* from service 
                INNER JOIN customer_vehicle ON service.id_cvehicle = customer_vehicle.id_cvehicle
                INNER JOIN vehicle ON vehicle.id_vehicle = customer_vehicle.id_vehicle
                INNER JOIN mechanic ON mechanic.id_mechanic=service.id_mechanic");

                while ($row=mysqli_fetch_array($sql)) {
                ?>
                    <tbody>
                    <tr>
                        <td><?php  echo $row['id_service'];?></td>
                        <td><?php  echo $row['id_customer'];?></td>
                        <td><?php  echo $row['reg'];?></td>
                        <td><?php  echo $row['type'];?></td>
                        <td><?php  echo $row['make_model'];?></td>
                        <td><?php  echo $row['date'];?></td>
                        <td><?php  echo $row['time'];?></td>
                        <td><?php  echo $row['service_type'];?></td>
                        <td><?php  echo $row['status'];?></td>
                        <td><?php  echo $row['mec_name'];?></td>
                        <td><a href="edit_service.php?sid=<?php echo $row['id_service'];?>"><p class="fa fa-edit"></p></a>
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
