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

    if(isset($_POST['submit']))
    {

        
        $status=$_POST['status'];
        $mechanic=$_POST['id_mechanic'];
        $date=$_POST['date'];
        $time=$_POST['time'];
        $type=$_POST['service_type'];
        $sid=$_GET['sid'];
     
        $query=mysqli_query($mysqli, "UPDATE service SET status='$status', id_mechanic='$mechanic', date='$date',time= '$time', service_type='$type' where id_service=$sid"  );
        if ($query) {
        $msg="Service details has been update.";
        }
        else
        {
        $msg="Something Went Wrong. Please try again";
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
               $aid=$_SESSION["id_admin"];
               $sql = "SELECT name FROM admin Where id_admin = $aid";
               $result = $mysqli->query($sql);
               
             $row = $result->fetch_assoc();
                    echo "Logged in: " . $row["name"].  "<br>";
                
            ?>
                </p>
            </li>
            <li>
                <button type="button" class="btn btn-primary" href="#" data-toggle="modal"
                    data-target="#logoutModal">Sign Out</button>
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
                        <a href="#">Customer Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Overview</li>
                </ol>


                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Update Service Details</h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <?php
                                                    $sid=$_GET['sid'];
                                                        $ret=mysqli_query($mysqli,"SELECT service.*, customer.*, customer_vehicle.*, vehicle.*, mechanic.* from service 
                                                        INNER JOIN customer ON customer.id_customer = service.id_customer
                                                        INNER JOIN customer_vehicle ON service.id_cvehicle = customer_vehicle.id_cvehicle
                                                        INNER JOIN vehicle ON vehicle.id_vehicle = customer_vehicle.id_vehicle
                                                        INNER JOIN mechanic ON mechanic.id_mechanic=service.id_mechanic
                                                                        
                                                        WHERE id_service = $sid");
                                        
                                                                while ($row=mysqli_fetch_array($ret)) {

                                                               ?>
                                                <p style="font-size:16px; color:red" align = "center"> <?php if($msg){
                                                                    echo $msg;
                                                            }  ?> </p>

                                        

                                                <form class="form-horizontal" role="form" method="post" name="submit">
                                                <div class="card-header">Customer Details</div>
                                                <div class="card-body">
                                                
                                                <div class="form-row">
                                                  <div class="form-group col-md-4">
                                                  <label>Service ID</label>
                                                    <input type="text" name="id_service" class="form-control" value="<?php echo $row['id_service'];?>"disabled>
                                                  </div>
                                                  <div class="form-group col-md-4">
                                                  <label>Customer ID</label>
                                                      <input type="text" name="id_customer" class="form-control" value="<?php echo $row['id_customer'];?>"disabled>
                                                  </div>
                                                  <div class="form-group col-md-4">
                                                  <label>Name</label>
                                                      <input type="text" name="name" class="form-control" value="<?php echo $row['name'];?>"disabled>
                                                  </div>
                                                </div>    
                                                 
                                                <div class="form-row">
                                                  <div class="form-group col-md-4">
                                                  <label>Address</label>
                                                    <input type="text" name="address" class="form-control" value="<?php echo $row['address'];?>"disabled>
                                                  </div>
                                                  <div class="form-group col-md-4">
                                                  <label>Town</label>
                                                      <input type="text" name="town" class="form-control" value="<?php echo $row['town'];?>"disabled>
                                                  </div>
                                                  <div class="form-group col-md-4">
                                                  <label>County</label>
                                                      <input type="text" name="county" class="form-control" value="<?php echo $row['county'];?>"disabled>
                                                  </div>
                                                </div>  
                                                </div>  
                                                </div> 
                                                
                                                <div class="card-header">Vehicle Details</div>
                                                <div class="card-body">
                                                <div class="form-row">
                                                  <div class="form-group col-md-3">
                                                  <label>Reg</label>
                                                    <input type="text" name="reg" class="form-control" value="<?php echo $row['reg'];?>"disabled>
                                                  </div>
                                                  <div class="form-group col-md-3">
                                                  <label>Type</label>
                                                      <input type="text" name="type" class="form-control" value="<?php echo $row['type'];?>"disabled>
                                                  </div>
                                                  <div class="form-group col-md-3">
                                                  <label>Make/Model</label>
                                                      <input type="text" name="make_model" class="form-control" value="<?php echo $row['make_model'];?>"disabled>
                                                  </div>
                                                  <div class="form-group col-md-3">
                                                  <label>Engine Type</label>
                                                      <input type="text" name="engine_type" class="form-control" value="<?php echo $row['engine_type'];?>"disabled>
                                                  </div>
                                                </div> 
                                                </div>  
                                                

                                                <div class="card-header">Service Details</div>
                                                <div class="card-body">
                                                <div class="form-group">
                                                  <label>Coments</label>
                                                    <input type="text" name="comments" class="form-control" value="<?php echo $row['comments'];?>"disabled>
                                                  </div>      
                                                <div class="form-row">
                                                  <div class="form-group col-md-3">
                                                  <label>Service Type</label>

                                                  <select class="form-control" id="service_type" name="service_type" value="<?php echo $row['service_type'];?>">
                                                        <option><?php echo $row['service_type'];?></option>
                                                        <option>Annual Service</option>
                                                        <option>Major Service</option>
                                                        <option>Repair / Fault</option>
                                                        <option>Major Repair</option>
                                                </select>
                                                
                                                  </div>
                                                  <div class="form-group col-md-3">
                                                  <label>Date</label>
                                                      <input type="date" name="date" class="form-control" value="<?php echo $row['date'];?>">
                                                  </div>
                                                  <div class="form-group col-md-3">
                                                  <label>Time</label>
                                                      <input type="time" name="time" class="form-control" value="<?php echo $row['time'];?>">
                                                  </div>
                                                  <div class="form-group col-md-3">
                                                  <label>Status</label>
                                                  <select class="form-control" id="status" name="status">
                                                        <option><?php echo $row['status'];?></option>
                                                        <option>Booked</option>
                                                        <option>In Service</option>
                                                        <option>Completed</option>
                                                        <option>Collected</option>
                                                        <option>Unrepairable</option>
                                                            
                                                </select>

                                                  </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label>Mehanic</label>
                                                        <div class="form-row">
                                                            <select name="id_mechanic" id="id_mechanic" class="form-control"">
                                                            <option value="<?php echo $row['id_mechanic'];?>"><?php echo $row['mec_name'];?></option>
                                                                    <?php 
                                        
                                                                    $query=mysqli_query($mysqli,"SELECT * from mechanic");
                                                                    while($row=mysqli_fetch_array($query))
                                                                    {
                                                                        ?>    
                                                                        <option value="<?php echo $row['id_mechanic'];?>"><?php echo $row['mec_name'];?></option>
                                                                        <?php } ?>  
                                                            </select>
                                                        </div>
                                                    </div>  
                                                   
                                                </div> 
                                                
                                                        

                                                    <?php } ?>

                                                    <div class="form-group row">

                                                        <div class="col-12">
                                                            <p style="text-align: center;"> <button type="submit"
                                                                    name="submit"
                                                                    class="btn btn-primary btn-min-width mr-1 mb-1">Update</button>
                                                            </p>
                                                        </div>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                   

                                </div>
                            </div>
                        </div>
                        


                    </div> 

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
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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