<?php
// Include config file
require_once "includes/config.php";
 
// Define variables and initialize with empty values
$name = $address= $county = $town = $mobile = $email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id_customer FROM customer WHERE email = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    $name = trim($_POST["name"]);
    $address = trim($_POST["address"]);
    $county = trim($_POST["county"]);
    $town = trim($_POST["town"]);
    $mobile = $_POST["mobile"];

    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO customer (name, address, county, town, mobile, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssss", $param_name, $param_address, $param_county, $param_town, $param_mobile, $param_email, $param_password);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_county = $county;
            $param_town = $town;
            $param_mobile = $mobile;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
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

  <title>SB Admin - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-white">
  <div class="container">
    <div class="login">
      <div class="text-center">
        <a href="#body"><img src="../img/loginlogo.png" alt="" title="" /></a>
      </div>
    </div>
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Sign Up Form</div>
      <div class="card-body">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-row">
        <div class="col-md-6">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 
        </div> 
            <div class="col-md-6">
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>  
        </div> 
            <div class="col-md-6">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>County</label>
                <input type="text" name="county" class="form-control" value="<?php echo $county; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>  
        </div> 
            <div class="col-md-6">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>town</label>
                <input type="text" name="town" class="form-control" value="<?php echo $town; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>   
        </div> 
            <div class="col-md-6">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control" value="<?php echo $mobile; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>  
        </div> 
            <div class="col-md-6">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
        </div>  
            <div class="col-md-6">
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
        </div>
            <div class="col-md-6">
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
        </div>
        </div>
            <div class="form-group">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block" value="Submit">Submit</button>
                     &nbsp
                     <p>Already have an account? <a href="login.php">Login here</a>.</p>
                </div>
            </div>
        </form>
        
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
